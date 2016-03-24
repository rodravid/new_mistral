<ul>
    @forelse($orders as $order)
        <li>#ID do pedido: {{ $order->getId() }} - Total: {{ $order->getTotal() }}</li>

        <ul>
            @foreach($order->getItems() as $item)
                <li>
                    Item: {{ $item->getName() }} - Quantidade: {{ $item->getQuantity() }}<br>

                    @if($item->getProduct() instanceof Vinci\Domain\Product\Kit\Kit)

                        <ul>
                            @foreach($item->getProduct()->getItems() as $kitItem)
                                <li>{{ $kitItem->getName() }}</li>
                            @endforeach
                        </ul>

                    @endif

                </li>
            @endforeach
        </ul>

    @empty
        <h1>Você não possui nenhum pedido.</h1>
    @endforelse
</ul>