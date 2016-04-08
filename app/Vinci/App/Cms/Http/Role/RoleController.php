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
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Admin\AdminService;
use Vinci\Domain\Validation\ValidationException;

class RoleController extends Controller
{

    use DatatablesResponse;

    protected $adminService;

    protected $adminRepository;

    protected $datatable = 'Vinci\Infrastructure\ACL\Roles\Datatables\RolesCmsDatatable';

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        AdminService $adminService,
        AdminRepository $adminRepository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->adminService = $adminService;
        $this->adminRepository = $adminRepository;
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
        $user = $this->adminRepository->findOrFail($id);

        return $this->view('roles.edit')
            ->withUser($user);
    }

    public function store(Request $request)
    {

        $user = $this->adminRepository->find(1);

        $this->adminService->savePhoto($request->file('photo'), $user);

        dd('foi');

        try {

            $user = $this->adminService->create($request->all());

            $this->adminService->savePhoto($request->file('photo'), $user);

            Flash::success("Usuário {$user->getName()} criado com sucesso!");

            return Redirect::route('cms.roles.edit', $user->getId());

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