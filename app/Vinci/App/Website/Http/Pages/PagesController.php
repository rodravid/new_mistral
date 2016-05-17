<?php

namespace Vinci\App\Website\Http\Pages;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;

class PagesController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function index()
    {
        return $this->view('pages.list-page.index');
    }

    public function privacy()
    {
        return $this->view('pages.privacy.index');
    }

    public function frequentDoubts()
    {
        return $this->view('pages.frequent-doubts.index');
    }

    public function about()
    {
        return $this->view('pages.about.index');
    }

    public function dealers()
    {
        return $this->view('pages.dealers.index');
    }

}