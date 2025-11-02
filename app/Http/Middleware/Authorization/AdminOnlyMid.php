<?php

namespace App\Http\Middleware\Authorization;

use App\Interface\Middleware\Middleware;
use Database\Repository\MiddlewareRepository\AdminOnlyRepository;

class AdminOnlyMid implements Middleware
{

    function before(): void
    {
        $entityManager = doctrine();
        $adminOlyRepository = new AdminOnlyRepository($entityManager);

        try {
            $currentUser = $_SESSION["usersId"];
            $admin = $adminOlyRepository->GetAdminByUserId($currentUser);
            if ($admin == null){
                http_response_code(404);
                redirect("/404");
            }
        } catch (\Exception $e) {
            redirect("/404");
        }

    }
}