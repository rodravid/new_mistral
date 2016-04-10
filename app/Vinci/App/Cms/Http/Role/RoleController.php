<?php

namespace Vinci\App\Cms\Http\Role;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\ACL\Role\RoleRepository;
use Vinci\Domain\Validation\ValidationException;

class RoleController extends Controller
{

    use DatatablesResponse;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\ACL\Roles\Datatables\RolesCmsDatatable';

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        RoleRepository $repository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->repository = $repository;
        $this->aclService = $aclService;
    }

    public function index()
    {
        return $this->view('roles.list');
    }

    public function create()
    {
        $groupedPermissions = $this->aclService->getAllPermissionsGroupedByModule();

        return $this->view('roles.create', compact('groupedPermissions'));
    }

    public function edit($id)
    {
        $role = $this->repository->findOrFail($id);
        $groupedPermissions = $this->aclService->getAllPermissionsGroupedByModule();

        return $this->view('roles.edit', compact('role', 'groupedPermissions'));
    }

    public function store(Request $request)
    {
        try {

            $role = $this->aclService->createRole($request->all());

            Flash::success("Grupo {$role->getTitle()} criado com sucesso!");

            return Redirect::route('cms.roles.edit', $role->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

    public function update(Request $request, $customerId)
    {
        try {

            $user = $this->adminService->update($request->all(), $customerId);

            Flash::success("Usuário {$user->getName()} atualizado com sucesso!");

            return Redirect::route('cms.roles.edit', $user->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($userId)
    {
        $user = $this->adminRepository->find($userId);

        try {

            $this->adminRepository->delete($user);

            Flash::success("Usuário {$user->getName()} excluído com sucesso!");

            return Redirect::route('cms.roles.list');

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}