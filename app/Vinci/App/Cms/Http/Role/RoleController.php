<?php

namespace Vinci\App\Cms\Http\Role;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\ACL\Role\RoleRepository;

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

        $this->middleware('psarm');

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

            $data = $request->all();
            $data['modules'] = $request->get('modules', []);
            $data['permissions'] = $request->get('permissions', []);

            $role = $this->aclService->createRole($data);

            Flash::success("Grupo {$role->getTitle()} criado com sucesso!");

            return Redirect::route('cms.roles.edit', $role->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

    public function update(Request $request, $roleId)
    {
        try {

            $data = $request->all();
            $data['modules'] = $request->get('modules', []);
            $data['permissions'] = $request->get('permissions', []);

            $user = $this->aclService->updateRole($data, $roleId);

            Flash::success("Grupo {$user->getName()} atualizado com sucesso!");

            return Redirect::route('cms.roles.edit', $user->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($roleId)
    {
        $role = $this->repository->find($roleId);

        try {

            $this->repository->delete($role);

            Flash::success("Grupo {$role->getName()} excluído com sucesso!");

            return Redirect::route('cms.roles.list');

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}