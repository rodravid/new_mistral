<?php

namespace Vinci\App\Website\Http\Contact;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;

class ContactController extends Controller
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function index()
    {
        return $this->view('contact.index');
    }

    public function store(Request $request)
    {

    }

}