<div class="modal-default modal-delivery-time" ng-controller="ModalLoginCtrl">
    <div class="content-modal">

        <h2 class="title-modal-default">Prazo de Entrega</h2>
        <form action="{{ route('login') }}" method="POST" ng-submit="postLogin($event)">
            <ul class="list-form-register">
                <li>
                    <label for="cep" class="label-input">CEP</label>
                    <input class="cep input-register full" type="text" name="cep" ng-model="cep" placeholder="Cep" id="cep" cep>
                </li>
            </ul>
            <button class="bt-default-full bt-middle template1" type="submit">Consultar <span class="arrow-link">></span></button>
        </form>
        <p class="answer-delivery">4 dias para entrega</p>
    </div>
    <a href="javascript:void(0)" class="close">X</a>
</div>