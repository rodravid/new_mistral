<div class="wine-card">
    <favorite-widget product="{{ $product->id }}" favorited="@isProductFavorited($product->id)"></favorite-widget>

    <h3 class="title-card-wine">
        <a href="{{ $product->web_path }}">
            {!! $product->card_title !!}
            @if ($product->hasProducer())
                <span>{{ $product->producer->name }}</span>
            @endif
        </a>
    </h3>
    <p class="wine-intro">{{ $product->shortned_description }}</p>
    <div class="content-card-product">
        <div class="thumb-wine">
            @if($promotionSeal = $product->getPromotionSeal())
                <img class="label-wine" src="{{ $promotionSeal }}" alt="Selo Vinho">
            @else
                @if($product->isType('wine') && ($score = $product->getHighlitedScore()))
                    <div class="wrap-seal-card">
                        <div class="content-seal-card">
                            <div class="seal-score-card">
                                <img src="{{ asset_web('images/selo-grande.png') }}" alt="">
                                <span>{{ $score->value }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
            <a href="javascript:void(0);">
                <img class="wine-bottle" src="{{ $product->image_url }}" alt="Vinho">
            </a>
        </div>
        <div class="other-wine-info">
            <a href="javascript:void(0);">
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