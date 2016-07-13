<?php

namespace Vinci\App\Cms\Http\Account;

use Doctrine\ORM\EntityManagerInterface;
use Flash;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Admin\AdminService;

class AccountController extends Controller
{

    protected $adminService;

    protected $auth;

    public function __construct(EntityManagerInterface $em, AdminService $adminService, AuthManager $auth)
    {
        parent::__construct($em);

        $this->adminService = $adminService;
        $this->auth = $auth->guard('cms');
    }

    public function show()
    {
        $user = $this->auth->user();

        return $this->view('account.index', compact('user'));
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