<h1>Pedido realizado com sucesso!</h1>

<p>Pedido nº {{ $order->number }}</p>
<p>Data: {{ $order->creation_date }}</p>
<p>Cliente: {{ $order->customer->name }}</p>