<?php

namespace Vinci\App\Cms\Http\Account;

use Doctrine\ORM\EntityManagerInterface;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Admin\AdminService;

class AccountController extends Controller
{

    protected $adminService;

    public function __construct(EntityManagerInterface $em, AdminService $adminService)
    {
        parent::__construct($em);

        $this->adminService = $adminService;
    }

    public function show()
    {

        return $this->view('account.index');
        
    }

    public function update(Request $request, $userId)
    {
        try {
            $data = $request->all();
            $data['photo'] = $request->file('photo');

            $this->adminService->update($data, $userId);

            Flash::success('Perfil atualizado com sucesso!');

            return redirect()->route('cms.profile.show');

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        }
    }

}