<?php

use Vinci\App\Core\Utils\Mask;

function asset_web($path, $secure = null) {
    return asset("assets/website/{$path}", $secure);
}

function asset_cms($path, $secure = null) {
    return asset("assets/cms/{$path}", $secure);
}

function cmsUser()
{
    return auth('cms')->user();
}

function html_select_array($data, $key = 'id', $value = 'title')
{
    $result = [];

    foreach ($data as $item) {
        $result[$item->$key] = $item->$value;
    }

    return $result;
}

function uniqueHash()
{
    return md5(uniqid(rand()));
}

function present_status_html($status)
{
    switch($status) {
        case 0:
            return '<i class="fa fa-edit"></i><span class="text-info"> Rascunho</span>';
            break;

        case 1:
            return '<i class="fa fa-check"></i><span class="text-success"> Publicado</span>';
        break;
    }
}

function mask($txt, $mask) {
    if ($mask == Mask::PHONE)
        $mask = strlen($txt) == 10 ? '(##) ####-####' : '(##) #####-####';
    if ($mask == Mask::DOCUMENT) {
        if (strlen($txt) == 11)
            $mask = Mask::CPF;
        elseif (strlen($txt) == 14)
            $mask = Mask::CNPJ;
        else
            return $txt;
    }
    if (empty($txt))
        return '';
    $txt = unmask($txt);
    $qtd = 0;
    for ($x = 0; $x < strlen($mask); $x++) {
        if ($mask[$x] == "#")
            $qtd++;
    }
    if ($qtd > strlen($txt)) {
        $txt = str_pad($txt, $qtd, "0", STR_PAD_LEFT);
    }
    elseif ($qtd < strlen($txt))
    {
        return $txt;
    }
    if ($txt <> '') {
        $string = str_replace(" ", "", $txt);
        for ($i = 0; $i < strlen($string); $i++) {
            $pos = strpos($mask, "#");
            $mask[$pos] = $string[$i];
        }
        return $mask;
    }
    return $txt;
}

function unmask($text) {
    return preg_replace('/[\-\|\(\)\/\.\: ]/', '', $text);
}

function only_numbers($string)
{
    return preg_replace("/[^0-9]/", "", $string);
}

function currentTabActive($tabName, $activeClass = 'active', $first = false)
{
    if (old('current-tab') == $tabName) {
        return $activeClass;
    } else {

        if ($first && old('current-tab') == null) {
            return $activeClass;
        }

    }
}

function activeItem($pattern, $activeClass = 'active')
{
    if (app('request')->is($pattern . '*')) {
        return $activeClass;
    }
}

function getMonths()
{
    return [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ];
}

function money($number)
{
    return 'R$ ' . number_format($number, 2, ',', '.');
}

function validateCpf($cpf)
{

    /*
    Etapa 1: Cria um array com apenas os digitos numéricos,
    isso permite receber o cpf em diferentes formatos
    como "000.000.000-00", "00000000000", "000 000 000 00"
    */
    $j=0;
    for($i=0; $i<(strlen($cpf)); $i++)
    {
        if(is_numeric($cpf[$i]))
        {
            $num[$j]=$cpf[$i];
            $j++;
        }
    }

    if($j==0)
        return false;

    /*
    Etapa 2: Conta os dígitos,
    um cpf válido possui 11 dígitos numéricos.
    */
    if(count($num)!=11)
    {
        return false;
    }
    /*
    Etapa 3: Combinações como 00000000000 e 22222222222 embora
    não sejam cpfs reais resultariam em cpfs
    válidos após o calculo dos dígitos verificares e
    por isso precisam ser filtradas nesta parte.
    */
    else
    {
        for($i=0; $i<10; $i++)
        {
            if ($num[0]==$i && $num[1]==$i && $num[2]==$i && $num[3]==$i && $num[4]==$i && $num[5]==$i && $num[6]==$i && $num[7]==$i && $num[8]==$i)
            {
                return false;
                break;
            }
        }
    }
    if(!isset($isCpfValid))
    {
        $j=10;
        for($i=0; $i<9; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma%11;
        if($resto<2)
        {
            $dg=0;
        }
        else
        {
            $dg=11-$resto;
        }
        if($dg!=$num[9])
        {
            return false;
        }
    }
    /*
    Etapa 5: Calcula e compara o
    segundo dígito verificador.
    */
    if(!isset($isCpfValid))
    {
        $j=11;
        for($i=0; $i<10; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma%11;
        if($resto<2)
        {
            $dg=0;
        }
        else
        {
            $dg=11-$resto;
        }
        if($dg!=$num[10])
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    return true;
}

function validateCnpj($cnpj)
{
    /*
    Etapa 1: Cria um array com apenas os digitos numéricos,
    isso permite receber o cnpj em diferentes
    formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00"
    etc...
    */
    $j=0;
    for($i=0; $i<(strlen($cnpj)); $i++)
    {
        if(is_numeric($cnpj[$i]))
        {
            $num[$j]=$cnpj[$i];
            $j++;
        }
    }

    if($j==0)
        return false;

    //Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
    if(count($num)!=14)
    {
        return false;
    }
    /*
    Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria
    um cnpj válido após o calculo dos dígitos verificares
    e por isso precisa ser filtradas nesta etapa.
    */
    if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
    {
        return false;
    }
    //Etapa 4: Calcula e compara o primeiro dígito verificador.
    else
    {
        $j=5;
        for($i=0; $i<4; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $j=9;
        for($i=4; $i<12; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma%11;
        if($resto<2)
        {
            $dg=0;
        }
        else
        {
            $dg=11-$resto;
        }
        if($dg!=$num[12])
        {
            return false;
        }
    }
    //Etapa 5: Calcula e compara o segundo dígito verificador.
    if(!isset($isCnpjValid))
    {
        $j=6;
        for($i=0; $i<5; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $j=9;
        for($i=5; $i<13; $i++)
        {
            $multiplica[$i]=$num[$i]*$j;
            $j--;
        }
        $soma = array_sum($multiplica);
        $resto = $soma%11;
        if($resto<2)
        {
            $dg=0;
        }
        else
        {
            $dg=11-$resto;
        }
        if($dg!=$num[13])
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    return true;
}