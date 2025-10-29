<?php

namespace App\Enum\General;

enum EFormMethod: string
{
    case GET = "GET";
    case POST = "POST";
    case CUSTOM = "CUSTOM";
}