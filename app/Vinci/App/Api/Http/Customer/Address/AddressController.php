<?php

namespace Vinci\App\Api\Http\Customer\Address;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Api\Http\Controller;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Customer\Address\AddressService;

class AddressController extends Controller
{

    private $service;

    public function __construct(EntityManagerInterface $em, AddressService $service)
    {
        parent::__construct($em);

        $this->service = $service;
    }

    public function store(Request $request)
    {
        try {

            $this->service->create($request->all(), $request->get('customer'));

            return Response::json([
                'success' => true,
                'message' => 'Endereço cadastrado com sucesso!'
            ]);

        } catch (ValidationException $e) {

            return Response::json([
                'success' => false,
                'message' => $e->getErrors()
            ]);

        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

}