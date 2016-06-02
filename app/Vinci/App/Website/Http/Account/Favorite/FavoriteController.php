<?php

namespace Vinci\App\Website\Http\Account\Favorite;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Presenters\DefaultPaginatorPresenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $customerService;

    protected $favoriteService;

    public function __construct(EntityManagerInterface $em, FavoriteService $favoriteService)
    {
        parent::__construct($em);

        $this->favoriteService = $favoriteService;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('termo');

        $favorites = $this->favoriteService->getCustomerFavoriteProducts($this->user, 12, $keyword);

        $favorites = $this->presenter->paginator($favorites, ProductPresenter::class);

        $favorites = $this->presenter->model($favorites, DefaultPaginatorPresenter::class);

        return $this->view('account.favorite.index', compact('favorites', 'keyword'));
    }

}