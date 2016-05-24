@extends('website::layouts.master')

@section('content')
    <div class="header-internal header-checkout template1-bg">

        <div class="row">

            <div class="wrap-content-bt mbottom20 mtop20">
                <span class="logo">
                    <a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
                </span>
            </div>

            <h1 class="internal-subtitle">Meu Carrinho</h1>

            <nav class="nav-status float-right">
                <ul class="list-status">
                    <li class="current-status">
                        <span>Entrega</span>
                        <img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
                    </li>
                    <li class="show-desktop">
                        <span>Pagamento</span>

                    </li>
                    <li class="show-desktop">
                        <span>Confirmação</span>
                    </li>

                </ul>
            </nav>

        </div>
    </div>

    <div class="row">

        <div class="wrap-content-bt mbottom20">
            <span class="title-internal-15 float-left">Escolha o endereço de entrega</span>
            <div class="content-bt-middle hide-mobile">
                <a class="bt-default-full bt-color call-adress" href="javascript:void(0);">Novo endereço <span
                            class="arrow-link">&gt;</span></a>
            </div>
        </div>

        <section class="adress-delivery">

            {!! Form::open(['route' => 'checkout.payment.index', 'method' => 'GET']) !!}

            @foreach($addresses as $address)

                <div class="adress">
                    <a href="javascript:void(0);" class="bt-edit call-adress" title="Editar Endereço"> > </a>
                    <div class="content-adress mbottom20">
                        <h4 class="uppercase mbottom20">{{ $address->nickname }}</h4>
                        {!! $address->address_html !!}
                    </div>
                    <button type="submit" class="bt-default-full bt-color mtop20" name="address_id" value="{{ $address->id }}">Usar esse endereço <span class="arrow-link">&gt;</span></button>
                </div>

            @endforeach

            {!! Form::close() !!}

            <div class="wrap-content-bt mbottom20 show-mobile">
                <div class="content-bt-middle">
                    <a class="bt-default-full bt-color call-adress" href="#">Novo endereço <span class="arrow-link">&gt;</span></a>
                </div>
            </div>

        </section>
    </div>

    <div class="global-modal">
        <div class="modal-larger modal-adress template1">
            <div class="content-modal">
                <h2 class="title-modal-default">Novo Endereço</h2>
                <div class="user-data">
                    <!-- <h2 class="title-form">Endereço de Entrega *</h2> -->
                    <ul class="list-form-register">
                        <li>
                            <ul class="list-type-radio-3cols">
                                <li>
                                    <label for="residencial">Residencial</label>
                                    <input type="radio" name="delivery-addres" value="1" class="physical-person"
                                           id="residencial" checked>
                                </li>
                                <li>
                                    <label for="comercial">Comercial</label>
                                    <input type="radio" name="delivery-addres" value="2" class="legal-person"
                                           id="comercial">
                                </li>

                                <li>
                                    <label for="outros">Outros</label>
                                    <input type="radio" name="delivery-addres" value="3" class="legal-person"
                                           id="outros">
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="type-addres" class="label-input">Identificador do local *</label>
                            <input class="type-addres input-register full" type="text"
                                   placeholder="Identificador do local (Ex: casa, trabalho)" id="type-addres">
                        </li>
                        <li>
                            <label for="cep" class="label-input">CEP</label>
                            <input class="cep input-register half" type="text" placeholder="CEP" cep id="cep">
                            <div class="search-cep">
                                <p>Não sei o meu CEP.</p>
                                <a href="http://m.correios.com.br/movel/buscaCep.do" target="_blank">Faça a pesquisa
                                    aqui ></a>
                            </div>
                        </li>
                        <li>
                            <div class="select-standard half form-control-white">
                                <select class="" name="" id="">
                                    <option value="">Rua</option>
                                    <option value="">Avenida</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label for="address" class="label-input">Endereço</label>
                            <input class="input-register full" type="text" placeholder="Endereço" id="address">
                        </li>
                        <li>
                            <label for="num" class="label-input">n°</label>
                            <input class="number input-register two-fields" type="text" placeholder="n°" id="num">
                            <label for="complement" class="label-input">Complemento</label>
                            <input class="number input-register float-right two-fields" type="text"
                                   placeholder="Complemento" id="complement">
                        </li>
                        <li>
                            <div class="select-standard half form-control-white">
                                <select class="" name="" id="">
                                    <option value="">Estado</option>
                                    <option value="AL">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AM">AM</option>
                                    <option value="AP">AP</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MG">MG</option>
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="PR">PR</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="RS">RS</option>
                                    <option value="SC">SC</option>
                                    <option value="SE">SE</option>
                                    <option value="SP">SP</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </li>

                        <li>
                            <label for="bairro" class="label-input">Bairro</label>
                            <input class="input-register full" type="text" placeholder="Bairro" id="bairro">
                        </li>

                        <li>
                            <div class="select-standard full form-control-white">
                                <select class="" name="" id="">
                                    <option value="">Cidade</option>

                                </select>
                            </div>
                        </li>

                        <li>
                            <div class="select-standard full form-control-white">
                                <select class="" name="" id="">
                                    <option value="">País</option>
                                    <option value="SC">Brasil</option>

                                </select>
                            </div>
                        </li>

                        <li>
                            <label for="referencia" class="label-input">Referência para entrega</label>
                            <input class="input-register full" type="text" placeholder="Referência para entrega"
                                   id="referencia">
                        </li>
                    </ul>

                </div>
                <a class="bt-default-full bt-big template1" href="#">Cadastrar <span class="arrow-link">></span></a>
            </div>
            <!-- 	<div class="footer-modal">
                    <div class="center-content-bt">
                        <a href="/cadastro">
                            <span class="txt-register">Se você ainda não possui <br> conta, cadastre-se aqui</span>
                            <span class="bt-arrow">></span>
                        </a>
                    </div>
                </div> -->
            <a href="javascript:void(0)" class="close">X</a>
        </div>
    </div>
    <div class="overlay"></div>

    @include('website::layouts.partials.checkoutfooter')

@stop