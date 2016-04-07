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