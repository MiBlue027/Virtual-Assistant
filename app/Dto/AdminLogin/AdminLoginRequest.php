<?php

namespace App\Dto\AdminLogin;

use App\Attributes\DtoValidation\Validation;
use App\Enum\ValidationEnum\ERuleValidation;
use App\Exception\ExceptionCode;
use App\Exception\ExceptionMessage;

class AdminLoginRequest
{
    #[Validation(ERuleValidation::REQUIRED->value, exceptionCode: ExceptionCode::GENERAL_REQUIRED_INPUT)]
    public ?string $username = null;
    #[Validation(ERuleValidation::REQUIRED->value, exceptionCode: ExceptionCode::GENERAL_REQUIRED_INPUT)]
    public ?string $password = null;
}