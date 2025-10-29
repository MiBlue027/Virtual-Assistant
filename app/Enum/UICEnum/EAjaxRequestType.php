<?php
/*
| ======================================================================================================
| Name          : EAjaxRequestType
| Description   : This enum should be used to fill the RequestType parameter
|
| Created by    : Michael Christopher Otniel Wijanto (MiBlue Project)
| Creation Date : 2025-04-14
| Version       : 1.0.0
|
| Modifications:
|       - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
namespace App\Enum\UICEnum;

enum EAjaxRequestType: string
{
    case POST = 'POST';
    case GET = 'GET';
    case CUSTOM = 'CUSTOM';
}