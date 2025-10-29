<?php
/*
| ======================================================================================================
| Name          : View
| Description   : To handle view
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-06-02
| Version       : 1.0.0
|
| Modifications:
|       - v1.0.1 - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
namespace support;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use Path\RoutePath;

class View
{
    public static function RENDER(string $view, $model): void
    {
        try {
            require __DIR__ . "/../../../../app/View/html/header_html.php";
            require __DIR__ . "/../../../../app/View/{$view}.php";
            require __DIR__ . "/../../../../app/View/html/footer_html.php";
        } catch (Exception $e) {
            redirect(RoutePath::EXCEPTION_PAGE_ERROR);
        }

    }

    #[NoReturn] public static function REDIRECT(string $url): void
    {
        header("location: {$url}");
        exit();
    }
}