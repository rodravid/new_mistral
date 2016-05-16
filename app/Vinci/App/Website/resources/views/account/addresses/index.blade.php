@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.addresses.index') }}"><span>Endereços</span></a>
    </li>
@endsection

@section('account.content')

    <div class="wrap-content-bt mbottom20">
        <span class="title-internal-15 float-left">Lista de endereços cadastrados</span>
        <div class="content-bt-middle mtop-ajust">
            <a class="bt-default-full template11 call-adress" href="javascript:void(0);">Novo endereço <span class="arrow-link">&gt;</span></a>
        </div>
    </div>

    <section class="adress-delivery adress-user">

        <div class="adress template4">

            <div class="content-adress mbottom20">
                <h4 class="uppercase mbottom20">casa</h4>
                <p>Rua bahia, 1126, Higienópolis</p>
                <p>São Paulo - SP</p>
                <p>CEP 04412-300</p>
            </div>

            <a class="bt-default-full template11 mtop20" href="">Atualizar endereço <span class="arrow-link">&gt;</span></a>

        </div>

        <div class="adress template4">

            <div class="content-adress mbottom20">
                <h4 class="uppercase mbottom20">casa</h4>
                <p>Rua bahia, 1126, Higienópolis</p>
                <p>São Paulo - SP</p>
                <p>CEP 04412-300</p>
            </div>

            <a class="bt-default-full template11 mtop20" href="">Atualizar endereço <span class="arrow-link">&gt;</span></a>

        </div>

        <div class="adress template4">

            <div class="content-adress mbottom20">
                <h4 class="uppercase mbottom20">casa</h4>
                <p>Rua bahia, 1126, Higienópolis</p>
                <p>São Paulo - SP</p>
                <p>CEP 04412-300</p>
            </div>

            <a class="bt-default-full template11 mtop20" href="">Atualizar endereço <span class="arrow-link">&gt;</span></a>

        </div>

    </section>

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
                            <label for="type-addres" class="label-input">Tipo de endereço (Ex: casa, trabalho) *</label>
                            <input class="type-addres input-register full" type="text"
                                   placeholder="Tipo de endereço (Ex: casa, trabalho) *" id="type-addres">
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

            <a href="javascript:void(0)" class="close">X</a>
        </div>
    </div>

@endsection