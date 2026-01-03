<?php

namespace App\Http\Controller\ThreeJs;

class ThreeJsController
{
    function test()
    {
        view("threejs/three_js", [
            "title" => "Three JS",
        ]);
    }
}