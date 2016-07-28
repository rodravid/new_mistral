<h2 class="title-menu">{{ $title }}</h2>
<div class="featured-sub-menu">
    <div class="wrap-seal-card">
        @if($promotionSeal = $product->getPromotionSeal())
            <a href="{{ $product->web_path }}">
                <img class="label-wine" src="{{ $promotionSeal }}" alt="Selo Vinho">
            </a>
        @else
            @if($product->isType('wine') && ($score = $product->getHighlitedScore()))

                <div class="content-seal-card">
                    <div class="seal-score-card">
                        <a href="{{ $product->web_path }}">{!! $score->seal_img !!}</a>
                    </div>
                </div>
            @endif
        @endif
    </div>
    <a href="javascript:void(0);">
        <h3>
            {!! $product->card_title !!}
        </h3>
        @if ($product->hasProducer())
            <p class="wine-card-producer">{{ $product->producer->name }}</p>
        @endif
        <p class="featured-sub-descr">{{ $product->shortned_description }}</p>
        <p class="price-card-menu">{{ $product->sale_price }}</p>
    </a>
    <a href="javascript:void(0);" cart-add-button variant-id="{{ $product->getMasterVariant()->getId() }}" quantity="1" class="bt-default-full {{ $template }}">Comprar <span class="arrow-link">></span></a>
</div>