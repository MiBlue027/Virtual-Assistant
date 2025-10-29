<?php

namespace App\Http\Controller\AppController;

use App\Dto\AdminLogin\AdminLoginRequest;
use App\Exception\ValidationException;
use App\Service\AppService\AdminServices\AdminLoginService;
use Database\Repository\AppRepository\AdminRepository\AdminLoginRepository;
use Doctrine\ORM\EntityManager;
use Path\View\ViewTitle;
use PHPUnit\Exception;



class UserAuthenticationController
{
    private ?EntityManager $entityManager = null;
    public function __construct()
    {
        $this->entityManager = doctrine();
    }

    #region ADMIN LOGIN LOGOUT
    function login_view(): void
    {
        try {
            view("login", [
                "title" => "login",
            ]);
        } catch (\Exception $e){
            redirect("page_error_1");
        }
    }

    function login_request(): void
    {
        $adminLoginRepository = new AdminLoginRepository($this->entityManager);
        $adminLoginService = new AdminLoginService($adminLoginRepository);

        $request = new AdminLoginRequest();
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];
        try {
            $response = $adminLoginService->Login($request);
            $_SESSION["usersId"] = $response->user->getUsersId();
            $_SESSION["username"] = $request->username;

            redirect("/profile");
        } catch (\Exception $e){
            view("login", [
                "title" => "login",
                "username" => $request->username,
                "password" => $request->password,
                "message" => $e->getMessage(),
            ]);
        }
    }

    function logout(): void
    {
        session_destroy();
        redirect("/user/login");
    }
    #endregion

}