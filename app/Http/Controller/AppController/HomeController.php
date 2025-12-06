<?php
namespace App\Http\Controller\AppController;


use App\Service\AppService\HomeSvc;
use Database\Entities\RefQstSum;
use Database\Repository\ApiRepository\RefQstSumRepository;
use Database\Repository\GeneralRepository\UsersRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Exception;

class HomeController
{
    private EntityManager $entityManager;
    public function __construct(){
        $this->entityManager = doctrine();
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

        $repo = new UsersRepository($this->entityManager);
        $user = $repo->GetUsersAdminById($session);

        if ($user == null){
            $_SESSION["isGuest"] = true;
            redirect("/virtual-assistant");
        }

        $refQstSumRepo = new RefQstSumRepository($this->entityManager);

        $listKnowledgeQst = $refQstSumRepo->GetKnowledgeQuestion();
        $listUnknowledgeQst = $refQstSumRepo->GetUnknowledgeQuestion();

        $totalChat = $this->CountTotalChatHist();
        view("home", [
            "title" => "Home",
            "totalChat" => $totalChat,
            "listKnowledgeQst" => $listKnowledgeQst,
            "listUnknowledgeQst" => $listUnknowledgeQst
        ]);

    }

    public function clear_all_chat_hist()
    {
        try {
            $svc = new HomeSvc();
            $svc->ClearAllChatHist();

            $totalChat = $this->CountTotalChatHist();

            $refQstSumRepo = new RefQstSumRepository($this->entityManager);
            $listKnowledgeQst = $refQstSumRepo->GetKnowledgeQuestion();
            $listUnknowledgeQst = $refQstSumRepo->GetUnknowledgeQuestion();

            view("home", [
                "title" => "Home",
                "totalChat" => $totalChat
                , "listKnowledgeQst" => $listKnowledgeQst,
                "listUnknowledgeQst" => $listUnknowledgeQst
            ]);
        } catch (\Exception $e) {
            $totalChat = $this->CountTotalChatHist();
            view("home", [
                "title" => "Home",
                "totalChat" => $totalChat
                , "listKnowledgeQst" => $listKnowledgeQst,
                "listUnknowledgeQst" => $listUnknowledgeQst
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