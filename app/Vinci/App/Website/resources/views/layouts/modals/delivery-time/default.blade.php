<div class="modal-default modal-delivery-time">
    <div class="content-modal" shipping-deadline-widget>
        <h2 class="title-modal-default">Prazo de Entrega</h2>
        <form action="{{ route('api.shippingDeadline.calculate') }}" method="POST" ng-submit="submitForm($event)">
            <ul class="list-form-register">
                <li>
                    <label for="cep" class="label-input">CEP</label>
                    <input class="cep input-register full" type="text" name="shippingDeadline_cep" ng-model="cep" placeholder="Cep" id="cep">
                    <input type="hidden" name="product" ng-init="product = {{ $product->getId() }}">
                </li>
            </ul>
            <button class="bt-default-full bt-middle template1" ng-click="">Consultar <span class="arrow-link">></span></button>
        </form>
        <p class="answer-delivery"></p>
    </div>
    <a href="javascript:void(0)" class="close">X</a>
</div>