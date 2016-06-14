<div class="wine-card">
    <favorite-widget product="{{ $product->id }}" favorited="@isProductFavorited($product->id)"></favorite-widget>

    <h3 class="title-card-wine">
        <a href="{{ $product->web_path }}">
            {{ $product->card_title }}
            @if ($product->hasProducer())
                <span>{{ $product->producer->name }}</span>
            @endif
        </a>
    </h3>
    <p class="wine-intro">{!! $product->shortned_description !!}</p>
    <div class="content-card-product">
        <div class="thumb-wine">
            <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
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
                {{ $product->original_sale_price_html }}
                <p class="wine-price">
                    {{ $product->sale_price }}
                </p>
            </a>
        </div>

    </div>

    <a href="javascript:void(0);" cart-add-button variant-id="{{ $product->getMasterVariant()->getId() }}" quantity="1" class="bt-default">Comprar <span class="arrow-link">></span></a>
</div>