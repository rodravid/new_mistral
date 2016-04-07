<div class="row">

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserName">Nome</label>
            {!! Form::text('name', null, ['id' => 'txtUserName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserEmail">E-mail</label>
            {!! Form::text('email', null, ['id' => 'txtUserEmail', 'class' => 'form-control', 'placeholder' => 'Digite o e-mail']) !!}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserPassword">Senha</label>
            {!! Form::password('password', ['id' => 'txtUserPassword', 'class' => 'form-control', 'placeholder' => 'Digite a senha']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserPasswordConfirmation">Confirmação da senha</label>
            {!! Form::password('password_confirmation', ['id' => 'txtUserPasswordConfirmation', 'class' => 'form-control', 'placeholder' => 'Digite a senha novamente']) !!}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group has-feedback">
            <label for="txtUserPasswordConfirmation">Foto</label>
            {!! Form::file('photo', ['id' => 'txtUserPhoto']) !!}
            <span class="glyphicon glyphicon-picture form-control-feedback"></span>
        </div>
    </div>

</div>