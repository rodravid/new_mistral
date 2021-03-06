<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Vinci - Somos Loucos por Vinhos</title>
</head>

<body style="width:100%;margin:0 auto;font-family: 'Trebuchet', sans-serif;background:#f2f2f2;background-color:rgb(242,242,242) " bgcolor="#f2f2f2" class="largura-bd" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%;margin:0 auto;padding: 30px 0 0 0;background:#f2f2f2;background-color:rgb(242,242,242) " bgcolor="#f2f2f2" align="center">
        <tr>
            <td style="padding-bottom: 30px;">

                <table width="600" border="0" align="center" bgcolor="#FFFFFF">
                    <tbody>

                        @include('website::layouts.emails.templates.partials.header')
                        <tr valign="top">
                            <td style="padding: 33px 40px 33px 40px; font-size: 13px; color: #000000;">

                                <table cellspacing="0" cellpadding="0" border="0">
                                    @yield('body')
                                </table>

                                @include('website::layouts.emails.templates.partials.footer')
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>