<?php

namespace Vinci\App\Cms\Http\User;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Domain\Admin\AdminService;

class UserController extends Controller
{

    protected $adminService;

    private $adminRepository;

    public function __construct(EntityManagerInterface $em, AdminService $adminService, AdminRepository $adminRepository)
    {
        parent::__construct($em);

        $this->adminService = $adminService;
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return $this->view('users.index');
    }

    public function create()
    {
        return $this->view('users.create');
    }

    public function edit()
    {

    }

    public function store(Request $request)
    {
        try {

            $customer = $this->adminService->create($request->all());

            return redirect()->route('cms.account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

    public function update(Request $request, $customerId)
    {
        try {

            $this->adminService->update($request->all(), $customerId);

            return redirect()->route('cms.account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

    public function datatable()
    {
        $users = $this->adminRepository->paginateAll();

        $output = [
            "sEcho" => '',
            "iTotalRecords" => $users->total(),
            "iTotalDisplayRecords" => $users->count(),
            "aaData" => []
        ];

        foreach ($users as $user) {

            $output['aaData'][] = [
                '',
                $user->getId(),
                $user->getName(),
                $user->getEmail(),
                $user->getCreatedAt()->format('d/m/Y H:i:s'),
                'Editar'
            ];

        }

        return $output;

    }

}