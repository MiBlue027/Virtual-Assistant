<?php
namespace App\Http\Controller\AppController;


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

    function profile_redirect() : void
    {
        try {
            $session = $_SESSION["username"];
            view("profile", [
                "title" => "Profile",
                "user" => $session
            ]);
        } catch (\Exception $e) {
            redirect("/user/login");
        }

    }

}