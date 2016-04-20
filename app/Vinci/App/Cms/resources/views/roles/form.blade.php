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

    <div class="col-xs-12">
        <div class="checkbox">
            <label for="toggleAllPermissions"><input type="checkbox" id="toggleAllPermissions">Permissões</label>
        </div>

        <div class="row">
            @foreach($groupedPermissions as $permissionGroup)
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 select-container">
                    <div class="checkbox">
                        <label><input type="checkbox" name="modules[]" value="{{ $permissionGroup['module']->getId() }}" @if(isset($role) && $role->getModules()->contains($permissionGroup['module'])) checked @endif data-checkall><b>{{ $permissionGroup['module']->getTitle() }}</b></label>
                    </div>
                    <div class="form-group">
                        @foreach($permissionGroup['permissions'] as $permission)
                            @if($permission->canBeListed())
                                <div class="checkbox">
                                    <label><input type="checkbox" name="permissions[]" value="{{ $permission->getId() }}" @if(isset($role) && $role->getPermissions()->contains($permission)) checked @endif>{{ $permission->getDescription() }}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>