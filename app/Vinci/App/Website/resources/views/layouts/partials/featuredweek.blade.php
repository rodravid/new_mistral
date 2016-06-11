@if(isset($weekHighlightsShowcase))
    <section class="featured-week">
        <h4 class="title-featured-week">
            {{ $weekHighlightsShowcase->title }}
        </h4>

        <ul class="list-featured-week">
            @foreach($weekHighlightsProducts as $product)

                <li class="item-featured-week">
                    <a class="link-featured-week" href="{{ $product->web_path }}">
                        <p>{{ $product->title }}</p>

                        @if($product->hasProducer())
                            <span>{{ $product->producer->name }}</span>
                        @endif
                    </a>
                </li>

            @endforeach
        </ul>
    </section>
@endif