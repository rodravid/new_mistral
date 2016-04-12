<?php

namespace Vinci\App\Cms\Http\User;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\Role\RoleRepository;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Admin\AdminService;
use Vinci\Domain\Image\ImageRepository;

class UserController extends Controller
{

    use DatatablesResponse;

    protected $adminService;

    protected $adminRepository;

    protected $datatable = 'Vinci\Infrastructure\Admin\Datatables\UsersCmsDatatable';

    protected $roleRepository;

    protected $imageRepository;

    public function __construct(
        EntityManagerInterface $em,
        AdminService $adminService,
        AdminRepository $adminRepository,
        RoleRepository $roleRepository,
        ImageRepository $imageRepository
    )
    {
        parent::__construct($em);

        $this->adminService = $adminService;
        $this->adminRepository = $adminRepository;
        $this->roleRepository = $roleRepository;
        $this->imageRepository = $imageRepository;
    }

    public function index()
    {
        return $this->view('users.list');
    }

    public function create()
    {
        $roles = $this->getRolesSelectArray();

        return $this->view('users.create')->withRoles($roles);
    }

    public function edit($id)
    {
        $user = $this->adminRepository->findOrFail($id);
        $roles = $this->roleRepository->getAll();

        return $this->view('users.edit')
            ->withUser($user)
            ->withRoles($roles);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['photo'] = $request->file('photo');

            $user = $this->adminService->create($data);

            Flash::success("Usuário {$user->getName()} criado com sucesso!");

            return Redirect::route('cms.users.edit', $user->getId());

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

            $data = $request->all();
            $data['photo'] = $request->file('photo');

            $user = $this->adminService->update($data, $customerId);

            Flash::success("Usuário {$user->getName()} atualizado com sucesso!");

            return Redirect::route('cms.users.edit', $user->getId());

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

            return Redirect::route('cms.users.list');

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removePhoto($userId, $photoId)
    {
        try {

            $user = $this->adminRepository->find($userId);
            $photo = $this->imageRepository->find($photoId);

            $this->adminService->removePhoto($photo, $user);

            Flash::success("Foto excluída com sucesso!");

            return Redirect::route('cms.users.edit', [$userId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    protected function getRolesSelectArray()
    {
        $roles = $this->roleRepository->getAll();
        return html_select_array($roles);
    }

}