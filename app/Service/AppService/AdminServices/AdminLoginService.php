<?php

namespace App\Service\AppService\AdminServices;

use App\Dto\AdminLogin\AdminLoginRequest;
use App\Dto\AdminLogin\AdminLoginResponse;
use Database\Entities\Users;
use Database\Repository\AppRepository\AdminRepository\AdminLoginRepository;
use Exception;


class AdminLoginService
{
    private AdminLoginRepository $adminLoginRepository;
    public function __construct(AdminLoginRepository $adminLoginRepository)
    {
        $this->adminLoginRepository = $adminLoginRepository;
    }

    /**
     * @throws Exception
     */
    public function Login(AdminLoginRequest $request): ?AdminLoginResponse
    {
        $this->FormNullValidation($request);

        $admin = $this->adminLoginRepository->GetAdminByUsername($request->username);
        if ($admin == null){
            throw new Exception("Username or password is incorrect");
        }

        $this->UserLockValidation($admin);

        $password = decrypt_pass($admin->getPassword());
        if ($password == $request->password){
            $this->adminLoginRepository->LoginSuccess($admin);
            $response = new AdminLoginResponse();
            $response->user = $admin;
            return $response;
        } else {
            $this->adminLoginRepository->LoginFailed($admin);
            throw new Exception("Username or password is incorrect");
        }
    }

    /**
     * @throws Exception
     */
    private function FormNullValidation(AdminLoginRequest $request): void
    {
        if ($request->username == null || $request->password == null || trim($request->username) == "" || trim($request->password) == ""){
            throw new Exception("Please fill all field");
        }
    }

    /**
     * @throws Exception
     */
    private function UserLockValidation(Users $admin): void
    {
        if ($admin->isLock()){
            throw new \Exception("user is locked");
        }
    }

}