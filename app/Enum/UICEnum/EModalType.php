<?php
/*
| ======================================================================================================
| Name          : EModalType
| Description   : This enum should be used to fill the ModalType parameter
|
| Created by    : Michael Christopher Otniel Wijanto (MiBlue Project)
| Creation Date : 2025-04-28
| Version       : 1.0.0
|
| Modifications:
|       - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
namespace App\Enum\UICEnum;

enum EModalType: string
{
    case ALERT = "alert";
    case CONFIRMATION = 'confirmation';
    case NOTIFICATION = "notification";
}
