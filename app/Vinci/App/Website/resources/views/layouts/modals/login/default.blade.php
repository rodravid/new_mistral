<div class="modal-default modal-login" ng-controller="ModalLoginCtrl">
    <div class="content-modal">
        <h2 class="title-modal-default">Acesse sua conta</h2>
        <form action="{{ route('login') }}" method="POST" ng-submit="postLogin($event)">
            <ul class="list-form-register">
                <li>
                    <label for="email-login" class="label-input">E-mail</label>
                    <input class="email input-register full" type="text" name="email" ng-model="email" placeholder="E-mail" id="email-login">
                </li>
                <li>
                    <label for="senha-login" class="label-input">Senha</label>
                    <input class="senha input-register full" type="password" name="password" ng-model="password" placeholder="Senha" id="senha-login">
                    <a class="forgot-pass call-recovery" href="javascript:void(0);">Esqueceu a senha ?</a>
                </li>
            </ul>
            <p class="box-error" style="font-size: 14px; color: #f00;"></p>
            <button class="bt-default-full bt-middle template1" type="submit">Entrar <span class="arrow-link">></span></button>
        </form>
    </div>
    <div class="footer-modal">
        <div class="center-content-bt">
            <a href="/cadastro/">
                <span class="txt-register">Se você ainda não possui <br> conta, cadastre-se aqui</span>
                <span class="bt-arrow">></span>
            </a>
        </div>
    </div>
    <a href="javascript:void(0)" class="close">X</a>
</div>