<div class="row">

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserName">Título</label>
            {!! Form::text('title', null, ['id' => 'txtGroupTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título do grupo']) !!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserEmail">Descrição</label>
            {!! Form::textarea('description', null, ['id' => 'txtGroupDescription', 'class' => 'form-control', 'placeholder' => 'Descrição', 'rows' => 3, 'style' => 'resize:none;']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

</div>