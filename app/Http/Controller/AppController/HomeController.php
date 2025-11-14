<?php
namespace App\Http\Controller\AppController;


use App\Service\AppService\HomeSvc;
use Database\Repository\GeneralRepository\UsersRepository;
use PHPUnit\Exception;

class HomeController
{
    public function __construct(){

    }

    public function LandingPage(): void
    {
        redirect("/user/login");
//        view("landing_page", [
//            "title" => "Virtual Assistant"
//        ]);
    }

    public function home() : void
    {
        $session = $_SESSION["usersId"];
        $entityManager = doctrine();

        $repo = new UsersRepository($entityManager);
        $user = $repo->GetUsersAdminById($session);

        if ($user == null){
            $_SESSION["isGuest"] = true;
            redirect("/virtual-assistant");
        }
        $totalChat = $this->CountTotalChatHist();
        view("home", [
            "title" => "Home",
            "totalChat" => $totalChat
        ]);

    }

    public function clear_all_chat_hist()
    {
        try {
            $svc = new HomeSvc();
            $svc->ClearAllChatHist();

            $totalChat = $this->CountTotalChatHist();
            view("home", [
                "title" => "Home",
                "totalChat" => $totalChat
            ]);
        } catch (\Exception $e) {
            $totalChat = $this->CountTotalChatHist();
            view("home", [
                "title" => "Home",
                "totalChat" => $totalChat
            ]);
        }
    }

    private function CountTotalChatHist()
    {
        try {
            $svc = new HomeSvc();
            return $svc->GetTotalChatHist();
        } catch (\Exception $e) {
            return "Error";
        }
    }

}