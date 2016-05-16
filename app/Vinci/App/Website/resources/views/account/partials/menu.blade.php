<div class="wrap-menu-account-data">

    <div class="row">

        <div class="menu-account-mob">
            <p></p> <span class="seta-mobile-account">v</span>
        </div>

        <ul class="menu-account-data">

            <li class="{{ activeItem('minhaconta/pedidos', 'current-account-data') }}">
                <a href="{{ route('account.orders.index') }}">Meus pedidos</a>
            </li>

            <li class="{{ activeItem('minhaconta/editar', 'current-account-data') }}">
                <a href="{{ route('account.edit') }}">Dados da conta</a>
            </li>

            <li class="{{ activeItem('minhaconta/favoritos', 'current-account-data') }}">
                <a href="{{ route('account.favorite.index') }}">Favoritos</a>
            </li>

            <li class="{{ activeItem('minhaconta/enderecos', 'current-account-data') }}">
                <a href="{{ route('account.addresses.index') }}">Endereços</a>
            </li>

        </ul>

    </div>

</div>