<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ $loggedUser->profile_photo }}" class="img-circle" alt="Foto perfil">
            </div>
            <div class="pull-left info" style="margin-top: 10px;">
                <p>{{ cmsUser()->name }}</p>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" id="mainMenu">
            <li class="header">MENU</li>
            {!! $modules !!}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>