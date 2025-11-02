<?php
namespace App\Http\Controller\AppController;


use Database\Repository\GeneralRepository\UsersRepository;

class HomeController
{
    public function __construct(){

    }

    public function LandingPage(): void
    {
        view("landing_page", [
            "title" => "Virtual Assistant"
        ]);
    }

    function home() : void
    {
        try {
            $session = $_SESSION["usersId"];
            $entityManager = doctrine();

            $repo = new UsersRepository($entityManager);
            $user = $repo->GetUsersAdminById($session);

            if ($user == null){
                $_SESSION["isGuest"] = true;
                redirect("/virtual-assistant");
            }

            view("home", [
                "title" => "Home",
                "user" => $user->getUsername()
            ]);
        } catch (\Exception $e) {
            redirect("/user/login");
        }

    }

}