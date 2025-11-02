<?php

namespace App\Http\Controller\AppController;

class ExceptionController
{
    public function page404()
    {
        view('page_not_found', [
            "title" => "Page Not Found",
        ]);
    }
}