<?php

namespace Vinci\App\Api\Http;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Core\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{

    protected $user;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->user = Auth::guard('cms')->user();
    }

}