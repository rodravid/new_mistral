<?php
namespace Vinci\App\Website\Http\GoogleShopping;

use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\GoogleShopping\GoogleShoppingService;

class GoogleShoppingController extends Controller
{
    private $googleShoppingService;

    public function __construct(GoogleShoppingService $googleShoppingService)
    {
        $this->googleShoppingService = $googleShoppingService;
    }

    public function index()
    {
        $content = $this->googleShoppingService->generateGoogleShoppingXML();
        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }
}