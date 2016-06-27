<?php

namespace Vinci\App\Website\Http;

use Redirect;

class RedirectController extends Controller
{
    protected $urls = [
        '002' => '/c/pais/africa-do-sul',
        '003' => '/c/pais/alemanha',
        '005' => '/c/pais/argentina',
        '006' => '/c/pais/australia',
        '008' => '/c/pais/brasil',
        '009' => '/c/pais/chile',
        '011' => '/c/pais/espanha',
        '012' => '/c/pais/estados-unidos',
        '013' => '/c/pais/franca',
        '015' => '/c/pais/hungria',
        '016' => '/c/pais/italia',
        '018' => '/c/pais/nova-zelandia',
        '019' => '/c/pais/portugal',
        '020' => '/c/pais/uruguai',
        '021' => '/c/pais/grecia',
    ];

    public function redirectWithStatus301()
    {
        
        $country = empty($_REQUEST['idCountry']) ? '008' : $_REQUEST['idCountry'];
        return Redirect::to($this->urls[$country], 301);

    }
}