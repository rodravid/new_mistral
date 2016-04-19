<div class="row">

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserName">Descrição</label>
            {!! Form::text('description', null, ['id' => 'txtDollarDescription', 'class' => 'form-control', 'placeholder' => 'Digite uma descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserEmail">Valor do dólar</label>
            {!! Form::text('amount', null, ['id' => 'txtDollarAmount', 'class' => 'form-control', 'placeholder' => 'Digite o valor do dólar']) !!}
            <span class="fa fa-money form-control-feedback"></span>
        </div>
    </div>

</div>