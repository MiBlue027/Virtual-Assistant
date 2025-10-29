<?php
/*
| ======================================================================================================
| Name          : EDataColumnAlign
| Description   : This enum must be used to declare the alignment type for the class object that will serve as the template column for the table.
|
| Created by    : Michael Christopher Otniel Wijanto (MiBlue Project)
| Creation Date : 2025-03-24
| Version       : 1.0.0
|
// Modifications:
|       - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
namespace App\Enum\UICEnum;
enum EDataColumnAlign: string
{
    case LEFT = 'left';
    case RIGHT = 'right';
    case CENTER = 'center';
}