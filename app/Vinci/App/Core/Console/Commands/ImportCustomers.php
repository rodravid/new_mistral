<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Product\Services\ProductManagementService;
use GuzzleHttp\Client;
use Vinci\Infrastructure\Services\Postmon\Facades\Postmon;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers { --limit=1 }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa os clientes da tabela bkp_customers';

    private $em;
    /**
     * @var ProductManagementService
     */
    private $service;

    public function __construct(EntityManager $em, CustomerService $service)
    {
        parent::__construct();

        $this->em = $em;
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->create();
    }

    public function create()
    {
        $stmt = $this->em->getConnection()->prepare('SELECT * FROM bkp_customers WHERE id != "" AND imported = 0 limit ' . $this->option('limit'));
        $stmt->execute();

        $customers = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $total = count($customers);
        $error = 0;

        if ($total) {
            $this->line('');
            $this->info("importing " . $total . " customers(s).");
            $this->line('');

            $progressBar = $this->output->createProgressBar($total);
            foreach ($customers as $customer) {

                $data = [];
                $data["importId"] = $customer["id"];
                $data["customerType"] = $customer["tipo"];
                $data["name"] = $this->normalizeValue($customer["nome"]);
                $data["email"] = $this->normalizeValue($customer["email"]);
                $data["gender"] = $this->normalizeValue($customer["sexo"]);
                $data["birthday"] = date("d/m/Y", strtotime($customer["data_nascimento"]));

                $cpf = strlen($this->normalizeValue($customer["cpf"])) < 11 ? str_pad($this->normalizeValue($customer["cpf"]), 11, "0", STR_PAD_LEFT) : $this->normalizeValue($customer["cpf"]);
                $data["cpf"] = $cpf;

                $rg = strlen($this->normalizeValue($customer["rg"])) > 12 ? substr($this->normalizeValue($customer["cpf"]), 0, 12) : $this->normalizeValue($customer["cpf"]);
                $data["rg"] = $rg;

                $data["issuingBody"] = $this->normalizeValue($customer["orgao_emissor"]);
                $data["companyName"] = "";
                $data["companyContact"] = $this->normalizeValue($customer["contato_empresa"]);
                $data["cnpj"] = $this->normalizeValue($customer["cnpj"]);
                $data["stateRegistration"] = $this->normalizeValue($customer["inscricao"]);
                $data["phone"] = $this->normalizePhoneNumber($customer["ddd_telefone"], $customer["telefone"]);
                $data["cellPhone"] = $this->normalizePhoneNumber($customer["ddd_celular"], $customer["celular"]);
                $data["commercialPhone"] = $this->normalizePhoneNumber($customer["ddd_comercial"], $customer["comercial"]);

                $data["password"] = $this->normalizeValue($customer["senha"]);
                $data["password_confirmation"] = $this->normalizeValue($customer["senha"]);

                $data["cryptKey"] = $this->normalizeValue($customer["senhaCrypto"]);

                $data["main_address"] = "0";
                $data["status"] = "1";

                $stmt_address = $this->em->getConnection()->prepare('select * from bkp_customers_addresses where customer_id = ?;');
                $stmt_address->execute([$customer["id"]]);
                $addresses = $stmt_address->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($addresses as $key => $address) {

                    $postmon = $this->getDataPostmon($this->normalizeValue($address["postal_code"]));

                    if (isset($postmon["cidade_info"])) {
                        $data["addresses"][$key]["id"] = "";
                        $data["addresses"][$key]["type"] = $address["type_id"];
                        $data["addresses"][$key]["postal_code"] = $this->normalizeValue($address["postal_code"]);
                        $data["addresses"][$key]["nickname"] = ($address["type_id"] == 1 || $address["type_id"] == 2) ? "" : $this->normalizeValue($address["nickname"]);
                        $data["addresses"][$key]["public_place"] = $address["public_place_id"];
                        $data["addresses"][$key]["address"] = $this->normalizeValue($address["address"]);
                        $data["addresses"][$key]["number"] = $this->normalizeValue($address["number"]);
                        $data["addresses"][$key]["complement"] = $this->normalizeValue($address["complement"]);
                        $data["addresses"][$key]["district"] = $this->normalizeValue($address["district"]);

                        $data["addresses"][$key]["country"] = "30";
                        $data["addresses"][$key]["state"] = isset($postmon["estado_info"]["codigo_ibge"]) ? $postmon["estado_info"]["codigo_ibge"] : null;
                        $data["addresses"][$key]["city"] = $postmon["cidade_info"]["codigo_ibge"];
                        $data["addresses"][$key]["landmark"] = $this->normalizeValue($address["landmark"]);
                        $data["addresses"][$key]["receiver"] = $this->normalizeValue($address["receiver"]);

                        $stmt_upd = $this->em->getConnection()->prepare('update bkp_customers_addresses set city_id="' . $postmon["cidade_info"]["codigo_ibge"] . '" where id = ' . $address["id"]);
                        $stmt_upd->execute();

                    }

                }

                //dd($data);

                try {

                    $data['disable_events'] = true;

                    $result = $this->service->create($data);
                    $stmt = $this->em->getConnection()->prepare('update bkp_customers set imported=1 where id = ?;');
                    $stmt->execute([$customer["id"]]);

                } catch (ValidationException $e) {
                    $stmt = $this->em->getConnection()->prepare('update bkp_customers set imported=2 where id = ?;');
                    $stmt->execute([$customer["id"]]);

                    $this->line('');
                    $this->error("Erro ao adicionar o cliente [" . $customer["id"] . "]");
                    $this->info($e->getErrors()->first());
                    $this->line('');

                    $error++;

                } catch (UniqueConstraintViolationException $e) {

                    if (! $this->em->isOpen()) {
                        $this->em = $this->em->create(
                            $this->em->getConnection(),
                            $this->em->getConfiguration()
                        );

                        $this->service->setEntityManager($this->em);
                        app()->instance(EntityManagerInterface::class, $this->em);
                    }

                    $stmt = $this->em->getConnection()->prepare('update bkp_customers set imported=2 where id = ?');
                    $stmt->execute([$customer["id"]]);
                    $this->line('');
                    $this->error("Erro ao adicionar o cliente [" . $customer["id"] . "]");
                    $this->info($e->getMessage());
                    $this->line('');
                    $error++;
                    
                } catch (ForeignKeyConstraintViolationException $e) {

                    if (! $this->em->isOpen()) {
                        $this->em = $this->em->create(
                            $this->em->getConnection(),
                            $this->em->getConfiguration()
                        );

                        $this->service->setEntityManager($this->em);

                        app()->instance(EntityManagerInterface::class, $this->em);
                    }

                    $stmt = $this->em->getConnection()->prepare('update bkp_customers set imported=2 where id = ?;');
                    $stmt->execute([$customer["id"]]);
                    $this->line('');
                    $this->error("Erro ao adicionar o cliente [" . $customer["id"] . "]");
                    $this->info($e->getMessage());
                    $this->line('');
                    $error++;

                } catch (\Exception $e) {
                    $stmt = $this->em->getConnection()->prepare('update bkp_customers set imported=2 where id = ?;');
                    $stmt->execute([$customer["id"]]);
                    $this->line('');
                    $this->error("Erro ao adicionar o cliente [" . $customer["id"] . "]");
                    $this->info($e->getMessage());
                    $this->line('');
                    $error++;
                    
                } finally {
                    $this->em->clear();
                }

                $progressBar->advance();

            }
            $progressBar->finish();
            $this->line("\n");
            $this->info($error . ' error');
            $this->info(($total - $error) . ' imported');
            $this->line('');

        }


    }

    public function normalizeValue($value)
    {
        if ($value == "NULL" || empty($value)) {
            return "";
        }

        return trim($value);
    }

    public function normalizePhoneNumber($ddd, $phone)
    {
        return sprintf('%s%s', $this->normalizeValue($ddd), $this->normalizeValue($phone));
    }

    public function getDataPostmon($cep)
    {
        try {
            return Postmon::getAddress($cep);
        } catch (\Exception $e) {

        }
    }


}