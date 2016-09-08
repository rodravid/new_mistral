<?php

namespace Vinci\App\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Order\Creation\OrderCreationService;
use Vinci\Domain\Product\Product;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;
use Vinci\Domain\ShoppingCart\ShoppingCart;

class GenerateOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:generate { quantity=10 }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate random orders';

    private $orderCreationService;

    private $customerRepository;

    public function __construct(OrderCreationService $orderCreationService, CustomerRepository $customerRepository)
    {
        parent::__construct();

        $this->orderCreationService = $orderCreationService;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $quantity = $this->getQuantity();

        $this->info(sprintf('Generating %s orders...', $quantity));

        $progressBar = $this->output->createProgressBar($quantity);

        for ($i = 1; $i <= $quantity; $i++) {

            try {

                $this->generateOrder();

            } catch (Exception $e) {

                $this->info($e->getMessage());

            } finally {
                app('em')->clear();
            }

            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info("\n\nDone!");

    }

    private function generateOrder()
    {
        $customer = $this->getCustomer();

        $channel = $this->getChannel();

        $cart = $this->generateNewShoppingCart($customer);

        $data = [
            'customer' => $customer,
            'channel' => $channel,
            'cart' => $cart,
            'shipping' => [
                'address' => $customer->getMainAddress()->getId()
            ],
            'payment' => [
                'installments' => '',
                'method' => 5,
            ],
            'document' => '431.036.028-98'
        ];

        return $this->orderCreationService->create($data);
    }

    protected function getCustomer()
    {
        return $this->customerRepository->findByEmail('felipe.ralc@gmail.com');
    }

    protected function getChannel()
    {
        return app('em')->getReference(Channel::class, 1);
    }

    protected function generateNewShoppingCart($customer)
    {
        $cart = new ShoppingCart();

        $products = $this->getProducts()->random(rand(2, 5));

        $products->map(function($product) use ($cart) {

            $item = new ShoppingCartItem;

            $item
                ->setQuantity(rand(1, 10))
                ->setProductVariant($product->getMasterVariant());

            $cart->addItem($item);
        });

        $cart->setCustomer($customer);

        return $cart;
    }

    public function getProducts()
    {
        return collect([758, 135, 819, 6, 1703])->map(function($productId) {
            return app('em')->getReference(Product::class, $productId);
        });
    }

    private function getQuantity()
    {
        return intval($this->argument('quantity'));
    }

}