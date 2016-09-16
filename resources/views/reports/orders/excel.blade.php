<table>
    <thead>
    <tr>
        <th height="20px">#ID</th>
        <th height="20px"><i class="fa fa-tag"></i> N&uacute;mero</th>
        <th height="20px"><i class="fa fa-user"></i> Cliente</th>
        <th height="20px"><i class="fa fa-money"></i> Valor</th>
        <th height="20px"><i class="fa fa-calendar"></i> Criado em</th>
        <th height="20px"><i class="fa fa-edit"></i> Status</th>
        <th height="20px"><i class="fa fa-edit"></i> Status da integra&ccedil;&atilde;o</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr>
                <td height="16px" width="5px">{{ $order->id }}</td>
                <td height="16px" width="13px">{{ $order->number }}</td>
                <td height="16px" width="37px">{{ $order->customer->name }}</td>
                <td height="16px" width="25px">{{ $order->total }}</td>
                <td height="16px" width="27px">{{ $order->created_at }}</td>
                <td height="16px" width="75px">{{ $order->status }}</td>
                <td height="16px" width="20px">{!! $order->integration_status_html !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>