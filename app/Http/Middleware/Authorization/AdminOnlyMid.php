<?php

namespace App\Http\Middleware\Authorization;

use App\Exception\AppException;
use App\Interface\Middleware\Middleware;
use Database\Repository\MiddlewareRepository\AdminOnlyRepository;
use Path\RoutePath;

class AdminOnlyMid implements Middleware
{

    function before(): void
    {
        $entityManager = doctrine();
        $adminOlyRepository = new AdminOnlyRepository($entityManager);

        try {
            $currentUser = get_access_token()->users_id;
            $admin = $adminOlyRepository->GetAdminByUserId($currentUser);
            if ($admin == null){
                http_response_code(404);
                redirect(RoutePath::EXCEPTION_PAGE_NOT_FOUND);
            }
        } catch (AppException $e) {
            redirect(RoutePath::EXCEPTION_PAGE_NOT_FOUND);
        }

    }
}