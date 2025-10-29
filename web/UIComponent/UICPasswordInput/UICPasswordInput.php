<?php
/*
| ======================================================================================================
| Name          : UI Component Password Input
| Description   : To create a custom password input field that includes the functionality to hide and show the password entered by the user.
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-03-24
| Version       : 1.0.1
|
| Modifications:
|       - v1.0.1 - Michael Christopher Otniel Wijanto on 2025-05-11: Move all scripts to a separate file
| ======================================================================================================
*/
/*
 | To do next: Menambahkan fitur password strength checker
 */
namespace UIC\UICPasswordInput;
class UICPasswordInput
{

    public function __construct()
    {
    }

    #region PROPERTIES
    private string $eyeShow = "eye-outline.svg";
    private string $eyeHide = "eye-off-outline.svg";
    #endregion

    #region PUBLIC METHOD
    public function FilledIcon($isFilled = false): void
    {
        if ($isFilled) {
            $this->eyeShow = "eye.svg";
            $this->eyeHide = "eye-off.svg";
        }
        else{
            $this->eyeShow = "eye-outline.svg";
            $this->eyeHide = "eye-off-outline.svg";
        }
    }
    #endregion

    #region RENDER
    public function Render(
        string $id
        , string $name
        , string $value = ""
        , string $label = ""
        , string $placeholder = ""
        , bool $visible = true
        , bool $disable = false
        , string $style = ""
        , string $class = ""
        , ?array $errors = []
    )
    {
        $error = $errors[$name] ?? null;
        ?>
            <div class="dUICPasswordInputContainer  <?= $class ?>" style="display: <?= $visible ? "" : "none" ?>; <?= $style ?>">
                <label for="<?= $id ?>"> <?= $label ?> </label>
                <div class="dUICPasswordInput">
                    <input type="password"
                           id="<?= $id ?>"
                           name="<?= $name ?>"
                           <?= ($disable) ? "disabled" : "" ?>
                           value="<?php echo $value ?>"
                           placeholder="<?= $placeholder ?>"
                    >
                    <span class="spnIcon-dUicInputBox">
                        <img src="<?php echo config("uic_config.icon_path") . $this->eyeHide ?>"
                             alt="eye-outline.svg" class="ibPassShowHideJQ"
                             data-target="<?php echo $id ?>"
                             data-eye-show="<?php echo $this->eyeShow ?>"
                             data-eye-hide="<?php echo $this->eyeHide ?>"
                             data-icon-path="<?php echo config("uic_config.icon_path") ?>"
                        >
                    </span>
                </div>
                <div id="dUICPasswordInput_<?= $id ?>">
                    <p> <?= $error ?? "" ?> </p>
                </div>
            </div>
        <?php
    }
    #endregion


}