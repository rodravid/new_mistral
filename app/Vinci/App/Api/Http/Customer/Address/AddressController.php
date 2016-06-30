<?php

namespace Vinci\App\Api\Http\Customer\Address;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Log;
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
                'message' => $e->getErrors()->first(),
                'fields' => $e->getErrors()->getMessages()
            ]);

        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ]);

        }
    }

    public function update($address, Request $request)
    {
        try {

            $this->service->update($request->all(), $request->get('customer'), $address);

            return Response::json([
                'success' => true,
                'message' => 'Endereço atualizado com sucesso!'
            ]);

        } catch (ValidationException $e) {

            return Response::json([
                'success' => false,
                'message' => $e->getErrors()->first()
            ]);

        } catch (Exception $e) {

            Log::error(sprintf('Erro ao atualizar endereço: %s', $e->getMessage()));

            return Response::json([
                'success' => false,
                'message' => 'Não foi possível atualizar o endereço. Tente novamente mais tarde.'
            ]);

        }
    }

}