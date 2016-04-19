@extends('cms::export.excel')

@section('body')

    <table class="table">
        <thead>
        <tr>
            <th colspan="10">Vinci - Newsletter {{ \Carbon\Carbon::now()->format('d/m/Y') }}</th>
        </tr>
        <tr>
            <th>#ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Lançamentos e promoções</th>
            <th>Grandes jantares e eventos</th>
            <th>Criado em</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $newsletter)
            <tr>
                <td>{{ $newsletter->id }}</td>
                <td>{{ $newsletter->name }}</td>
                <td>{{ $newsletter->email }}</td>
                <td>{{ $newsletter->accept_promotions }}</td>
                <td>{{ $newsletter->accept_events }}</td>
                <td>{{ $newsletter->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection