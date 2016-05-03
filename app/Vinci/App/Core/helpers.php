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