<div class="wine-card">
    <div class="thumb-wine">
        <a href="{{ $product->web_path }}">
            <img class="wine-bottle" src="{{ $product->image_url }}" alt="Vinho">
        </a>
        @if($promotionSeal = $product->getPromotionSeal())
            <img class="label-wine" src="{{ $promotionSeal }}" alt="Selo Vinho">
        @else
            @if($product->isType('wine') && ($score = $product->getHighlitedScore()))
                <div class="wrap-seal-card">
                    <div class="content-seal-card">
                        <div class="seal-score-card">
                            <img src="{{ $score->seal_img }}" alt="">
                            <span>{{ $score->value }}</span>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
    
    <div class="container-max-line">

    <div class="colum-description-wine">
        <h3 class="title-card-wine">
            <a href="{{ $product->web_path }}">
                {{ $product->title }}
                @if($product->hasProducer())
                    <span>{{ $product->producer->name }}</span>
                @endif
            </a>
            <favorite-widget product="{{ $product->id }}" favorited="@isProductFavorited($product->id)"></favorite-widget>
        </h3>
        <a href="{{ $product->web_path }}">
            <p class="wine-intro">{!! $product->shortned_description !!}</p>
            @if($product->hasAttributeByName('bottle_size'))
                <p class="info-details-wine">{{ $product->getAttribute('bottle_size')->getValue() }}</p>
            @endif
            @if($product->hasCountry())
                <p class="info-details-wine">{{ $product->country->name }}</p>
            @endif
            @if($product->hasProductType())
                <p class="info-details-wine">{{ $product->productType->name }}</p>
            @endif
        </a>
    </div>
    <div class="other-wine-info">
    @if($product->isAvailable())
        {!! $product->original_sale_price_html !!}
        <p class="wine-price">{{ $product->sale_price }}</p>

        <a href="javascript:void(0);" class="bt-default" cart-add-button variant-id="{{ $product->getMasterVariant()->getId() }}" quantity="1">Comprar <span class="arrow-link">></span></a>
         @else

        <p class="product-unavailable">
            Produto indisponível no site
        </p>
        @endif
    </div>
    </div>
</div>