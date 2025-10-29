<?php

namespace App\Enum\UICEnum;

enum ECommonInput_Type: string
{
    case EMAIL = "email";
    case NUMBER = "number";
    case TEXT = "text";
    case TEXT_AREA = "textarea";
}
