@extends('website::layouts.emails.templates.default')

<?php $color = '#de1e43'; ?>
@section('header.title', 'Seja Bem-vindo')
@section('header.bg.color', $color)
@section('footer.img.src', asset_web('images/emails/logo-footer-red.jpg'))

@section('body')

    @include('website::layouts.emails.templates.partials.salutation')
    <tr>
        <td style="padding:10px 0;">
            <span style="color:{{ $color }};font-family:Arial, verdana, sans-serif; font-size:18px;">
                Obrigado por se cadastrar na VINCI Vinhos.
            </span>
        </td>
    </tr>

    <tr>
        <td style="padding-top:20px;">
             <span style="color:#000000;font-family:Arial, verdana, sans-serif; font-size:15px;">
        Descubra nossos vinhos. São mais de 1000 rótulos de 15 países diferentes, e mais de 150 produtores exclusivos do mais alto nível, entre as maiores estrelas de suas regiões - todos especialmente selecionados pelo enófilo Ciro Lilla. São vinhos de conhecedores, que gozam de enorme prestígio internacional e que estão na Vinci para conquistarem um merecido lugar na sua adega.
    </span>
        </td>
    </tr>

    <tr>
        <td style="padding-top:20px;">
            <a target="_blank" href="http://www.vinci.com.br">
                <img alt="Clique aqui" src="{{ asset_web('images/emails/bt-click.jpg') }}" style="display:block;" border="0">
            </a>
        </td>
    </tr>

    <tr>
        <td style="padding-top:25px;">
            <span style="font-size: 15px; font-family:Arial, verdana, sans-serif;">
                Confira abaixo as informações que agora constam no cadastro:
            </span>
        </td>
    </tr>

    <tr>
        <td style="padding:30px 0 20px 0px">
            <b style="color:{{ $color }}; font-family:Arial, verdana, sans-serif; font-size: 18px;">Dados pessoais</b>
        </td>
    </tr>

    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Nome
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->name }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        CPF/CNPJ
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->document }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @if(! empty($customer->rg))
        <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        RG
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->rg }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    @endif
    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    @if ($customer->isIndividual())
    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Sexo
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->gender }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Data de Nascimento
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->birthday }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @endif

    <tr>
        <td style="padding:40px 0 22px 0">
            <b style="color:{{ $color }}; font-family:Arial, verdana, sans-serif; font-size: 18px;">Endereço</b>
        </td>
    </tr>

    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Tipo
                    </td>

                    <td width="300" style="font-size: 15px">
                        {!! $customer->getMainAddress()->getType()->getTitle() !!}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Endereço
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->address }}
                        {{ $customer->getMainAddress()->number }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    @if(! empty($customer->getComplement))
    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                       Complemento
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->complement }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    @endif

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                       Bairro
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->district }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Cidade
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->city_name }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        CEP
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->postal_code }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Estado
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->getMainAddress()->state_name }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding:40px 0 12px 0">
            <b style="color:{{ $color }}; font-family:Arial, verdana, sans-serif; font-size: 18px;">Contatos</b>
        </td>
    </tr>
    @if(! empty($customer->phone))
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Telefone
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->phone }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    @endif

    @if(! empty($customer->cellPhone))
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        Telefone Celular:
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->cellPhone }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    @endif

    @if(! empty($customer->commercialPhone))
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="190" style="font-size: 15px">
                            Telefone Comercial
                        </td>

                        <td width="300" style="font-size: 15px">
                            {{ $customer->commercialPhone }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td height="12" style="line-height:12px;border-bottom:solid 1px #bbcad1">&nbsp;</td></tr>
    @endif

    <tr>
        <td style="padding-top: 10px">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="190" style="font-size: 15px">
                        E-mail
                    </td>

                    <td width="300" style="font-size: 15px">
                        {{ $customer->email }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding-top: 20px; padding-bottom: 35px; font-size: 15px;font-family:Arial, verdana, sans-serif;">
            Qualquer dúvida, entre em contato pelo e-mail
            <br>
            <span style="color: {{ $color }};"><b>internet@vinci.com.br</b></span>
            <br><br>
            Ou ligue para <br>
            <span style="color: {{ $color }};"><b>(11) 3031-4646</b></span> <br>
            Horário de atendimento telefônico é de segunda a sexta-feira das 9h às 18h, <br> sábado das 9h às 13h, exceto em feriados.
            <br><br>
            Atenciosamente <br>
            Equipe de Comércio Eletrônico

        </td>
    </tr>


    {{--@include('website::layouts.emails.templates.partials.additional_message')--}}

@endsection