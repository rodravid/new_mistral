@extends('website::layouts.master')

@section('content')
    <div class="header-internal template6-bg">
        @include('website::layouts.menu')
        <div class="row">

            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <span>Termos de uso, privacidade e segurança</span>
                </li>
            </ul>
            <h1 class="internal-subtitle">Termos de uso, privacidade e segurança</h1>
        </div>
    </div>

    <div class="row">

        <article class="wrap-content-term-of-use">
            <div class="term-of-use">
                <span class="title-internal-15">Conheça abaixo nossos Termos de Uso.</span>
                <p>
                    Em caso de mais dúvidas entre em contato através do email <a href="mailto:info@vinci.com.br"><span>info@vinci
                            .com.br</span></a> ou ligue para (11) 2797-
                    0000 (o horário de atendimento telefônico para clientes de internet é de segunda a sexta-feira de
                    9h00 às
                    18h00, exceto feriados).
                </p>
                <p>
                    O uso deste site está sujeito a certos termos e condições. Ao utilizar nossos serviços ou efetuar
                    compras,
                    você está aceitando estes termos e condições, especificados abaixo:
                </p>
                <p>
                    A venda de vinhos ou de qualquer outra bebida alcóolica é vedada a menores de 18 anos.
                    Dirigir sob a influência de álcool configura delito, passível de sanção penal.
                </p>
                <p>
                    Todas as informações, textos, imagens, logos, downloads e outros conteúdos deste site são de
                    propriedade
                    de Vinci Importadora e Exportadora de Bebidas Ltda ou de empresas a ela associadas, incluindo
                    produtores internacionais de vinho. Nenhum destes conteúdos poderá ser copiado, reproduzido,
                    distribuído ou utilizado de qualquer forma e em qualquer tipo de mídia sem a autorização expressa e
                    por
                    escrito da Vinci.
                </p>
                <p>
                    Os dados pessoais fornecidos pelos clientes do site são armazenados em servidores seguros, de acesso
                    restrito a funcionários da Vinci. Para sua segurança, os dados de cartão de crédito não são
                    armazenados
                    em nosso servidor, sendo de uso exclusivo do banco.
                </p>

            </div>

            <div class="security-policy">

                <span class="title-internal-15">Política de Privacidade e Segurança</span>
                <p>
                    Conheça abaixo nossa Política de Privacidade e Segurança. <br>
                    Em caso de mais dúvidas entre em contato através do e-mail <a href="mailto:info@vinci.com.br"><span>info@vinci
                            .com.br</span></a> ou ligue para (11) 2797-
                    0000.
                </p>
                <p>
                    Os dados pessoais fornecidos por você, como nome, endereço, telefone e email, são para uso exclusivo
                    da
                    Vinci e sob nenhuma hipótese serão cedidos a qualquer outra empresa.
                </p>
                <p>
                    Ao se cadastrar, você pode escolher se deseja ou não receber emails especiais da Vinci, com dicas,
                    informações, notícias e promoções especiais. A qualquer momento, você pode alterar sua opção de
                    receber ou não estes emails e comunicados. Seu email ou dados pessoais nunca serão cedidos a nenhuma
                    outra empresa.
                </p>
                <p>
                    Nosso site faz uso de cookies e outras tecnologias de internet, de forma a tornar sua navegação mais
                    interessante e apresentar conteúdos mais adequados a seu gosto pessoal. A compra via internet pelo
                    site da
                    Vinci é muito segura e utiliza-se criptografia para garantir a transação de sua compra.
                </p>
                <p>
                    A Vinci é certificada pelo selo de segurança - GoDaddy.
                </p>
            </div>
        </article>

    </div>

    <div class="border-footer">
        @include('website::layouts.footer')
    </div>

@stop