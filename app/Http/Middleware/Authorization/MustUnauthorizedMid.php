<?php

namespace App\Http\Middleware\Authorization;

use App\Exception\AppException;
use App\Interface\Middleware\Middleware;

class MustUnauthorizedMid implements Middleware
{
    function before(): void
    {
        if (isset($_SESSION["usersId"])) {
            redirect("/home");
        }
    }
}