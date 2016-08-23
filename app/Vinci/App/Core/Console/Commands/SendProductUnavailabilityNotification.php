<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Mail;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Showcase\ShowcaseItem;
use Vinci\Domain\Showcase\ShowcaseRepository;

class SendProductUnavailabilityNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:send-unavailability-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notification with products out of stock.';

    protected $em;

    protected $showcaseRepository;

    protected $adminRepository;

    public function __construct(EntityManagerInterface $em, ShowcaseRepository $showcaseRepository, AdminRepository $adminRepository)
    {
        parent::__construct();

        $this->em = $em;
        $this->showcaseRepository = $showcaseRepository;
        $this->adminRepository = $adminRepository;
    }

    public function handle()
    {
        list($productsHome, $productsDefault, $total) = $this->getProducts();

        if ($total > 0) {

            $receivers = $this->getReceivers();

            $this->info(sprintf('Sending product unavailability notification mail to %s users...', $receivers->count()));

            $bar = $this->output->createProgressBar($receivers->count());

            foreach ($receivers as $receiver) {

                try {

                    $data = [
                        'productsHome' => $productsHome,
                        'productsDefault' => $productsDefault,
                        'total' => $total,
                        'receiver' => $receiver,
                        'date' => Carbon::now()->format("d/m/Y \à\s H:i\h")
                    ];

                    Mail::send('website::layouts.emails.product.default.product_unavailability_notification', $data, function(Message $message) use ($data, $receiver) {

                        $message->subject('Vinci Vinhos - Notificação de indisponibilidade de produtos - ' . $data['date']);
                        $message->to($receiver->getEmail(), $receiver->getName());

                    });

                } catch (Exception $e) {
                    throw $e;
                }

                $bar->advance();

            }

            $bar->finish();

            $this->info("\nDone!");

        } else {
            $this->info('Nothing to do.');
        }

    }

    protected function getReceivers()
    {
        return collect($this->adminRepository->findByRole(['super-admin', 'admin']));
    }

    private function getProducts()
    {
        $productsInHomeShowcases = $this->getUnavailableProductsInHomeShowcases();

        $qb = $this->em->createQueryBuilder();

        $qb->select('p.id, v.sku, v.title, v.slug, p.online')
            ->from(Product::class, 'p')
            ->join('p.variants', 'v')
            ->where($qb->expr()->eq('v.stock', 0))
            ->andWhere('p.online = 1');

        if ($productsInHomeShowcases->count()) {
            $qb->andWhere($qb->expr()->notIn('p.id', $productsInHomeShowcases->map(function($product) { return $product['id']; } )->toArray()));
        }

        $products = collect($qb->getQuery()->getArrayResult());

        $total = $productsInHomeShowcases->count() + $products->count();

        return [$productsInHomeShowcases, $products, $total];
    }

    private function getUnavailableProductsInHomeShowcases()
    {
        $showcases = $this->showcaseRepository->lists('home-showcases');

        $products = collect();

        foreach ($showcases as $showcase) {
            $products = $products->merge($this->getProductsFromShowcase($showcase));
        }

        return $products;
    }

    public function getProductsFromShowcase($showcase)
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('p.id, v.sku, v.title, v.slug, p.online')
            ->from(ShowcaseItem::class, 'i')
            ->join('i.showcase', 's')
            ->join('i.product', 'p')
            ->join('p.variants', 'v')
            ->where($qb->expr()->eq('s.id', $showcase->getId()))
            ->andWhere($qb->expr()->eq('v.stock', 0));

        return $qb->getQuery()->getArrayResult();
    }

}
