@extends('website::layouts.master')

@section('content')
    <div class="header-internal bg-sobre-vinci template11-bg"
         style="background: url({{ asset_web('images/bg-sobre-vinci.jpg') }}) no-repeat center;">
        @include('website::layouts.menu')
        <div class="row">

            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>

                <li class="breadcrumb-item">
                    <span>Sobre a Vinci</span>
                </li>
            </ul>

            <h1 class="internal-subtitle">uma das melhores e mais premiadas importadoras de vinhos do país</h1>

        </div>
    </div>

    <div class="row">

        <article class="wrap-content-about-vinci template10">

            <div class="colum-620 about-vinci">

                <p>
                    Em poucos lugares do mundo você consegue encontrar uma seleção de vinhos e produtores tão
                    conceituados e premiados como no catálogo da Vinci. Nomes exclusivos como Noemía, O.Fournier,
                    Errazuriz, Kaiken, Luca - Laura Catena, Champagne Henriot, Comte Lafond de Ladoucette, Viña
                    Tondonia, CVNE, La Spinetta, Caves São João, Niepoot, Palácio da Brejoeira, Rust en Vrede,
                    Castellare di Castellina, Boutari, Selbach-Oster, Bonny Doon e tantos outros que você só encontra na
                    Vinci.
                </p>

                <p>
                    São mais de 1000 rótulos de 15 países diferentes, e mais de 150 produtores exclusivos do mais alto
                    nível, entre as maiores estrelas de suas regiões - todos especialmente selecionados pelo enófilo
                    Ciro Lilla. São vinhos de conhecedores, que gozam de enorme prestígio internacional e que estão na
                    Vinci para conquistarem um merecido lugar na sua adega.
                </p>

                <p>
                    Descubra nossos vinhos. Se você gosta de variar, <strong>a Vinci é sua melhor alternativa.</strong>
                </p>

                <p>
                    <strong class="txt-contact">É fácil comprar na Vinci</strong>
                </p>

                <p>
                    Além da maravilhosa seleção de produtores exclusivos, a Vinci trata seus vinhos com o máximo
                    respeito e carinho. Nossos vinhos são transportados em containers refrigerados e armazenados em
                    temperatura controlada em nossas amplas e modernas instalações em São Paulo.
                </p>

                <p>
                    Comprar na Vinci é fácil, e a entrega é rápida e eficiente. Despachamos para todo o Brasil e não há
                    pedido mínimo.
                </p>

                <p>
                    Se você mora em São Paulo, não deixe de visitar a Vinci Pamplona. Se você é um amante de vinhos,
                    você é muito importante para a Vinci e vai ser tratado com toda a atenção que merece.
                </p>

                <p>
                    A Vinci tem toda a facilidade de compra e respeito ao vinho que você tanto valoriza. E com sua
                    seleção exclusiva de produtores e vinhos premiados, <strong>a Vinci é mesmo sua melhor
                        alternativa.</strong>
                </p>

                <p>
                    <strong>
                        Nossos vinhos importados da Vinci são entregues pela distribuidora homologada: MV Net
                        Distribuidora de Bebidas Ltda - CNPJ 12.500.701/0001-79 - São Paulo - SP - Fale Conosco pelo
                        Telefone (11) 2797-0000
                    </strong>
                </p>

            </div>

            <sidebar class="sidebar">
                <p>
                    <span class="txt-contact">Vinci Pamplona</span>
                    Rua Pamplona 917 - Jardim Paulista <br>
                    São Paulo - SP <br>
                    (11) 3130 4500 <br>
                </p>

                <p>
                    <span class="txt-contact">Novo horário de atendimento a partir do dia 02/05/2016:</span>
                    Segunda a sexta-feira das 10h00 às 19h00 <br>
                    Sábados das 10h00 às 15h00
                </p>

                <div class="container-maps mbottom20">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.0725781998126!2d-46.65779158469348!3d-23.565836684680708!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c60edf6ecd%3A0x422f264cbca69d43!2sR.+Pamplona%2C+917+-+Jardim+Paulista%2C+S%C3%A3o+Paulo+-+SP%2C+01405-001!5e0!3m2!1spt-BR!2sbr!4v1462287642197"
                            height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>

                <p>
                    <strong>
                        Estacionamentos
                    </strong>
                </p>

                <p>ESTACIONE AKI <br>
                    Rua Pamplona, 833 <br>
                    (atendimento de segunda-feira a sábado)
                </p>

                <p>
                    ESTACIONE <br>
                    Rua Pamplona, 972 <br>
                    (atendimento de segunda a sexta-feira)
                </p>

                <p>
                    *Cortesia válida para a primeira hora e em compras
                </p>
            </sidebar>


        </article>
        @include('website::layouts.partials.featuredweek')
    </div>

    @include('website::layouts.footer')

@stop