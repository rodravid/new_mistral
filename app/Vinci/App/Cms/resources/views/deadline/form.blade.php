<div class="row">

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserName">Descrição</label>
            {!! Form::text('description', null, ['id' => 'txtDeadlineDescription', 'class' => 'form-control', 'placeholder' => 'Digite uma descrição']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserEmail">Prazo de entrega</label>
            {!! Form::text('days', null, ['id' => 'txtDeadlineDays', 'class' => 'form-control', 'placeholder' => 'Digite o prazo de enterga em dias']) !!}
            <span class="fa fa-calendar-times-o form-control-feedback"></span>
        </div>
    </div>

</div>