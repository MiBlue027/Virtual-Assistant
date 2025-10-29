/*
| ======================================================================================================
| Name          : global-script-js
| Description   : global script
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-05-20
| Version       : 1.0.0
|
| Modifications :
|       - v1.0.1 -   [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/

// region PREVENT WEB INSPECTION
/*
| USE WHEN PRODUCTION!!!
 */
// document.addEventListener('contextmenu', event => event.preventDefault());
// document.addEventListener('keydown', function(e) {
//     if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
//         e.preventDefault();
//     }
// });
// endregion

// region AUDIO CTX
window.AudioCtx = new (window.AudioContext || window.webkitAudioContext)();
// endregion

