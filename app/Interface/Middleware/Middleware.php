<?php

namespace App\Interface\Middleware;

interface Middleware
{
    function before(): void;
}