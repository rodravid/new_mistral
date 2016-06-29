<div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
        <strong>Cliente</strong>
        <address>
            @if ($loggedUser->hasPermissionTo('cms.customers.show'))
                <a href="{{ route('cms.customers.show', $order->customer->id) }}" target="_blank"><strong>{{ $order->customer->name }}</strong></a><br>
            @else
                <strong>{{ $order->customer->name }}</strong>
            @endif
            Telefone: {{ $order->customer->phone }}<br>
            Email: {{ $order->customer->email }}
        </address>
    </div>
    <div class="col-sm-3 invoice-col">
        <strong>Endereço de cobrança</strong>
        <address>
            {!! $order->billingAddress->address_html !!}
        </address>
    </div>
    <div class="col-sm-3 invoice-col">
        <strong>Endereço de entrega</strong>
        <address>
            {!! $order->shippingAddress->address_html !!}
        </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-3 invoice-col print-full">
        <b>Número do pedido:</b> {{ $order->number }}<br>
        <b>Realizado em:</b> {{ $order->created_at }}<br>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#SKU</th>
                <th>Produto</th>
                <th>Valor unitário</th>
                <th>Quantidade</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>

            @foreach($order->getItems() as $item)
                <tr>
                    <td>{{ $item->product->sku }}</td>
                    <td>{{ $item->product->title }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity_units }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <p class="lead">Forma de pagamento:</p>
        <p class="lead">{{ $order->payment->method->code }}</p>
        <img src="{{ $order->payment->method->icon_image_url }}" alt="Visa">

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            <strong>{{ $order->payment->installment_text }}</strong><br /><br >

            @if($order->payment->wasMadeWithCreditCard())

                <strong>Titular do cartão:</strong> {{ $order->payment->credit_card->holdername }}<br >
                <strong>Número:</strong> {{ $order->payment->credit_card->number }}<br >
                <strong>Data de expiração:</strong> {{ $order->payment->credit_card->expiry_date }}<br >
                <strong>Código de segurança:</strong> {{ $order->payment->credit_card->securityCode }}<br >

            @endif
        </p>
    </div>
    <div class="col-xs-6">

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th style="width:50%">Total dos items:</th>
                    <td>{{ $order->items_total }}</td>
                </tr>
                <tr>
                    <th>Frete:</th>
                    <td>{{ $order->shipment->amount }}</td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td>{{ $order->total }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>