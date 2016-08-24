<div class="global-modal">

    <div class="modal-x modal-gift">
        <div class="content-modal">

            <h2 class="title-modal-gift mbottom20">Selecione as embalagens</h2>

            <p class="txt-modal-gift mbottom20">
                Nesta área poderá selecionar quais embalagens deseja comprar e como serão as combinações
                dos produtos com as embalagens adquiridas. Caso não queira nenhuma das embalagens especiais,
                os produtos marcados com opção "embalar para presente" serão enviados em nossas embalagens gratuitas.
            </p>

            <div class="slider-gift">
                @foreach ($giftPackages as $giftPackage)
                    <div>

                        <img src="{{ $giftPackage->image_url }}" alt="{{ $giftPackage->title }}">
                        <p class="description-gift">{{ $giftPackage->title }}</p>
                        <p class="price-gift">{{ $giftPackage->sale_price }}</p>

                        <div class="content-button-gift">
                            <button class="bt-default-full template1" type="button" cart-add-button variant-id="{{ $giftPackage->getMasterVariant()->getId() }}">
                                Adicionar <span class="arrow-link">&gt;</span>
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
        <a href="javascript:void(0)" class="close">X</a>
    </div>

</div>