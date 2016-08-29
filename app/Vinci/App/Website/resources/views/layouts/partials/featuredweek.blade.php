@inject('productRepository', 'Vinci\Domain\Product\Repositories\ProductRepository')
@inject('presenter', 'Vinci\App\Core\Services\Presenter\Presenter')

@if(isset($showcase))

    @cache('teste-cache')

        <section class="featured-week">
            <h4 class="title-featured-week">
                {{ $showcase->title }}
            </h4>

            <?php
                $products = $productRepository->getProductsByShowcase($showcase->getId(), 12);
                $products = $presenter->paginator($products, 'Vinci\App\Website\Http\Product\Presenter\ProductPresenter');
            ?>

            <ul class="list-featured-week">
                @foreach($products as $product)

                    <li class="item-featured-week">
                        <a class="link-featured-week" href="{{ $product->web_path }}">
                            <p>{{ $product->title }}</p>

                            @if($product->hasProducer())
                                <span>{{ $product->producer->name }}</span>
                            @endif
                            <span>{{ $product->sale_price }}</span>
                        </a>
                    </li>

                @endforeach
            </ul>
        </section>
    @endcache
@endif