<?php

namespace Vinci\App\Website\Http\Home;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Showcase\ShowcaseRepository;

class HomeController extends Controller
{

    private $highlightRepository;

    private $showcaseRepository;

    private $productRepository;

    public function __construct(
        EntityManagerInterface $em,
        HighlightRepository $highlightRepository,
        ShowcaseRepository $showcaseRepository,
        ProductRepository $productRepository
    ) {

        parent::__construct($em);

        $this->highlightRepository = $highlightRepository;
        $this->showcaseRepository = $showcaseRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $highlights = $this->highlightRepository->lists('home-main-slider');

        $banners = $this->highlightRepository->lists('home-banners');

        $showcases = $this->showcaseRepository->lists('home-showcases');

        $showcases = $this->presenter->collection($showcases, ShowcasePresenter::class);

        return $this->view('home.index', compact('highlights', 'banners', 'showcases'));
    }

}