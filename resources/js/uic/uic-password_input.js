/*
| ======================================================================================================
| Name          : uic-password_input
| Description   : UICPasswordInput's script
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-05-11
| Version       : 1.0.0
|
| Modifications:
|       - v1.0.1 -   [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
$(document).on("click", ".ibPassShowHideJQ", function (){
    let input = $('#' + $(this).data('target'));
    let eyeShow = $(this).data('eyeShow');
    let eyeHide = $(this).data('eyeHide');
    let iconPath = $(this).data('iconPath');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        $(this).attr('src', iconPath + eyeShow);
    } else {
        input.attr('type', 'password');
        $(this).attr('src', iconPath + eyeHide);
    }
});