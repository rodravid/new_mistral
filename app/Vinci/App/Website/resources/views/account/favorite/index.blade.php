@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.favorite.index') }}"><span>Favoritos</span></a>
    </li>
@endsection

@section('account.content')

    <div class="wrap-pagination-favorites">

        <div class="container-total-products">
            <span class="total-products show-mobile">1 - 15 de 350 produtos</span>
        </div>

        <div class="search-internal">
            <input type="search" placeholder="Buscar" class="input-serach-internal">
            <input type="submit" class="sprite-icon bt-search-internal" value="">
        </div>

        <div class="container-left-pag">

            <div class="container-total-products">
                <span class="total-products show-desktop">1 - 15 de 350 produtos</span>
            </div>

            <ul class="pagination">
                <li>
                    <a href="javascript:void(0);" class="selected">1</a>
                </li>
                <li>
                    <a href="">2</a>
                </li>
                <li>
                    <a href="">3</a>
                </li>
                <li>
                    <a href="">4</a>
                </li>
                <li>
                    <a href="">5</a>
                </li>
                <li>
                    <a href="">></a>
                </li>
            </ul>

        </div>

    </div>

    <article class="wrap-content-four-line template4">

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>

        <div class="wine-card">
            <span class="favorite clicado opacity1"></span>

            <h3 class="title-card-wine">
                <a href="javascript:void(0);">
                    Kaiken terroir series Corte 2012
                    <span>Kaiken</span>
                </a>
            </h3>
            <p class="wine-intro">Aurelio Montes de Campo combinou as castas Malbec, Bonarda e Petit verdot para ...</p>
            <div class="content-card-product">
                <div class="thumb-wine">
                    <img class="label-wine" src="{{ asset_web('images/selo-pontos.png') }}" alt="Selo Vinho">
                    <a href="javascript:void(0);">
                        <img class="wine-bottle" src="{{ asset_web('images/img-vinho.jpg') }}" alt="Vinho">
                    </a>
                </div>
                <div class="other-wine-info">
                    <a href="javascript:void(0);">
                        <p class="info-details-wine">Tinto Pinot</p>
                        <p class="info-details-wine">Noir Chile</p>
                        <p class="in"> De <span>R$ 38,50</span></p>
                        <p class="wine-price">
                            R$ 72,26
                        </p>
                    </a>
                </div>

            </div>

            <a href="javascript:void(0);" class="bt-default">Comprar <span class="arrow-link">></span></a>
        </div>


    </article>

    <div class="container-total-products">
        <span class="total-products show-desktop">1 - 15 de 350 produtos</span>
    </div>

    <ul class="pagination">
        <li>
            <a href="javascript:void(0);" class="selected">1</a>
        </li>
        <li>
            <a href="">2</a>
        </li>
        <li>
            <a href="">3</a>
        </li>
        <li>
            <a href="">4</a>
        </li>
        <li>
            <a href="">5</a>
        </li>
        <li>
            <a href="">></a>
        </li>
    </ul>

@endsection