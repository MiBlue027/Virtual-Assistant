<?php

namespace App\Http\Controller\AppController;

use App\Dto\AdminLogin\AdminLoginRequest;
use App\Service\AppService\AdminServices\AdminLoginService;
use Database\Repository\AppRepository\LoginRepository\LoginRepository;
use Database\Repository\GeneralRepository\UsersRepository;
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
        $adminLoginRepository = new LoginRepository($this->entityManager);
        $adminLoginService = new AdminLoginService($adminLoginRepository);

        $request = new AdminLoginRequest();
        $request->username = $_POST["username"];
        $request->password = $_POST["password"];
        try {
            $response = $adminLoginService->Login($request);
            $userId = $response->user->getUsersId();
            $_SESSION["usersId"] = $userId;
            $_SESSION["username"] = $request->username;

            $repo = new UsersRepository($this->entityManager);
            $userAdmin = $repo->GetUsersAdminById($userId);

            if ($userAdmin == null){
                $_SESSION["guestId"] = $userId . "-" . bin2hex(random_bytes(4));
            }

            redirect("/home");
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

    function reset_guest_session(): void
    {
        $_SESSION["guestId"] = $_SESSION["usersId"] . "-" . bin2hex(random_bytes(4));
        redirect("/virtual-assistant");
    }

}