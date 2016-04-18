<?php

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