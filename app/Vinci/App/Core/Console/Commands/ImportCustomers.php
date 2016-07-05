<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Product\Services\ProductManagementService;
use GuzzleHttp\Client;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers {limit=1}';

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
        $conn = $this->em->getConnection();

        $stmt = $conn->prepare('select * from bkp_customers_vinci where imported=0 limit ' . $this->argument('limit'));
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
                $data["phone"] = $this->normalizeValue($customer["telefone"]);
                $data["cellPhone"] = $this->normalizeValue($customer["celular"]);
                $data["commercialPhone"] = $this->normalizeValue($customer["comercial"]);

                $data["password"] = $this->normalizeValue($customer["senha"]);
                $data["password_confirmation"] = $this->normalizeValue($customer["senha"]);

                $data["crypt_key"] = $this->normalizeValue($customer["senhaCrypto"]);

                $data["main_address"] = "0";
                $data["status"] = "1";

                $stmt_address = $conn->prepare('select * from bkp_customers_address_vinci where customer_id =' . $customer["id"]);
                $stmt_address->execute();
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

                        $stmt_upd = $conn->prepare('update bkp_customers_address_vinci set city_id="' . $postmon["cidade_info"]["codigo_ibge"] . '" where id = ' . $address["id"]);
                        $stmt_upd->execute();

                    }

                }

                //dd($data);

                try {
                    $result = $this->service->create($data);
                    $stmt = $conn->prepare('update bkp_customers_vinci set imported=1 where id = ' . $customer["id"]);
                    $stmt->execute();

                } catch (ValidationException $e) {
                    $stmt = $conn->prepare('update bkp_customers_vinci set imported=2 where id = ' . $customer["id"]);
                    $stmt->execute();

                    $this->line('');
                    $this->error("Erro ao adicionar o cliente [" . $customer["id"] . "]");
                    $this->info($e->getErrors()->first());
                    $this->line('');

                    $error++;

                } catch (UniqueConstraintViolationException $e) {

                    if (! $this->em->isOpen()) {
                        $this->entityManager = $this->em->create(
                            $this->em->getConnection(),
                            $this->em->getConfiguration()
                        );
                    }

                } catch (\Exception $e) {
                    $stmt = $conn->prepare('update bkp_customers_vinci set imported=2 where id = ' . $customer["id"]);
                    $stmt->execute();

                    $this->line('');
                    $this->error("Erro ao adicionar o produto [" . $customer["id"] . "]");
                    $this->info($e->getMessage());
                    $this->line('');

                    $error++;


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

        return $value;
    }

    public function getDataPostmon($cep)
    {
        try {
            $url = "http://api.postmon.com.br/v1/cep/" . $cep;
            $client = new Client([
                'base_uri' => $url,
                'timeout' => 2.0,
            ]);

            $response = $client->get($url)->getBody()->getContents();
            return json_decode($response, true);
        } catch (\Exception $e) {

        }

    }


}