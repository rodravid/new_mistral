<div class="wine-card">
    <favorite-widget product="{{ $product->id }}" favorited="@isProductFavorited($product->id)"></favorite-widget>

    <h3 class="title-card-wine">
        <a href="{{ $product->web_path }}">
            {!! $product->card_title !!}
        </a>
    </h3>
    @if ($product->hasProducer())
    <span class="wine-card-producer">{{ $product->producer->name }}</span>
    @endif
    <p class="wine-intro">{{ $product->shortned_description }}</p>
    <div class="content-card-product">
        <div class="thumb-wine">
            @if($promotionSeal = $product->getPromotionSeal())
            <a href="{{ $product->web_path }}">
                <img class="label-wine" src="{{ $promotionSeal }}" alt="Selo Vinho">
            </a>
            @else
                @if($product->isType('wine') && ($score = $product->getHighlitedScore()))
                    <div class="wrap-seal-card">
                        <div class="content-seal-card">
                            <div class="seal-score-card">
                                <a href="{{ $product->web_path }}">{!! $score->seal_img !!}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <a href="{{ $product->web_path }}">
                <img class="wine-bottle" src="{{ $product->card_image_url }}" alt="{!! $product->card_title !!} - {!! $product->producer->name !!}">
            </a>
        </div>
        <div class="other-wine-info">
            <a href="{{ $product->web_path }}">

                @if($product->hasAttributeByName('bottle_size'))
                    <p class="info-details-wine">{{ $product->getAttribute('bottle_size')->getValue() }}</p>
                @endif

                @if($product->hasCountry())
                    <p class="info-details-wine">{{ $product->country->name }}</p>
                @endif

                @if($product->hasProductType())
                    <p class="info-details-wine">{{ $product->productType->name }}</p>
                @endif

                @if($product->isAvailable())
                    {!! $product->original_sale_price_html !!}
                    <p class="wine-price">
                        {{ $product->sale_price }}
                    </p>
                @else
                    <p class="product-unavailable mtop20">
                        Produto indisponível no site
                    </p>
                @endif
            </a>
        </div>

    </div>
    @if($product->isAvailable())
        <a href="javascript:void(0);" cart-add-button variant-id="{{ $product->getMasterVariant()->getId() }}" quantity="1" class="bt-default">Comprar <span class="arrow-link">></span></a>
    @endif
</div>