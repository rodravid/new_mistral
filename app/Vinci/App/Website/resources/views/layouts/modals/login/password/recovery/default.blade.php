<div class="modal-default modal-recovery" ng-controller="ModalPasswordCtrl">
    <div class="content-modal">
        <h2 class="title-modal-default">Recuperar senha</h2>
        <form action="{{ route('password.email') }}" ng-submit="postReset($event)">
            <ul class="list-form-register">
                <li>
                    <label for="txtPasswordResetEmail">E-mail</label>
                    <input name="email" id="txtPasswordResetEmail" class="email input-register full" placeholder="E-mail" type="text" ng-model="email">
                    <p class="box-error" style="font-size: 14px; color: #f00;"></p>
                </li>
            </ul>
            <button type="submit" class="bt-default-full bt-middle template1">Enviar <span class="arrow-link">></span></button>
        </form>
    </div>
    <div class="footer-modal">
        <div class="center-content-bt">
            <a href="/cadastro">
                <span class="txt-register">Se você ainda não possui <br> conta, cadastre-se aqui</span>
                <span class="bt-arrow">></span>
            </a>
        </div>
    </div>
    <a href="javascript:void(0)" class="close">X</a>
</div>