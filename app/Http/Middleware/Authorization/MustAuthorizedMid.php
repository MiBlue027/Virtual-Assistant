<?php

namespace App\Http\Middleware\Authorization;

use App\Exception\AppException;
use App\Interface\Middleware\Middleware;
use Path\RoutePath;

class MustAuthorizedMid implements Middleware
{

    function before(): void
    {
        if (!isset($_SESSION["usersId"])) {
            redirect("/user/login");
        }
    }
}