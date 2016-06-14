<?php
namespace Vinci\App\Website\Http\Newsletter;

use Vinci\App\Website\Http\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Log;
use Response;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Newsletter\NewsletterService;

class NewsletterController extends Controller
{
    protected $newsletterService;

    public function __construct(EntityManagerInterface $em, NewsletterService $service)
    {
        parent::__construct($em);
        $this->newsletterService = $service;
    }

    public function store(Request $request)
    {
        try {
            
            $this->newsletterService->create($request->all());

            return Response::json(['message' => 'Contato cadastrado com sucesso! Obrigado pela preferência.']);
            
        } catch (ValidationException $e) {

            return Response::json(['data' => $e->getErrors()], 400);

        } catch (Exception $e) {
            Log::error(sprintf('Erro ao finalizar registro de newsletter: ', $e->getMessage()));

            return Response::json($e->getErrors(), 400);
        }
    }

}