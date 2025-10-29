<?php

namespace App\Enum\UICEnum;

enum EDropdown_SelectType: string
{
    case SELECT_NONE = "none";
    case SELECT_ONE = "select_one";
    case SELECT_ALL = "select_all";
}