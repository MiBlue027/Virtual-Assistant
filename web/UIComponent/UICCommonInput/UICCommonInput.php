<?php

namespace UIC\UICCommonInput;

use App\Constant\GeneralConstant\IconNameConstant;

class UICCommonInput
{
    public function __construct()
    {
    }

    #region RENDER
    public function Render(string $id
        , string $name
        , string $value = ""
        , string $label = ""
        , string $placeholder = ""
        , string $type = "text"
        , string $class = ""
        , bool $isMandatory = false
        , string $style = ""
        , int $textAreaRows = 10
        , int $textAreaCols = 20
        , int $textAreaMaxLength = 500
        , string $textAreaMinWidth = "100%"
        , string $textAreaMaxWidth = "100%"
        , string $textAreaMinHeight = "5em"
        , string $textAreaMaxHeight = "10em"
        , bool $disable = false
        , bool $visible = true
        , bool $readonly = false
        , ?array $errors = []
    )
    {
        $error = $errors[$name] ?? null;
        ?>
        <div class="dUICCommonInputContainerJQ dUICCommonInputContainer <?= $class ?>" style="display: <?= $visible ? "" : "none" ?>; <?= $style ?> ">
            <label for="<?= $id ?>"> <?= $label ?> </label>

            <?php if ($type === "textarea"): ?>
            <textarea id="<?= $id ?>"
                      name="<?= $name ?>"
                      placeholder="<?= $placeholder ?>"
                      class="<?= $isMandatory ? "UICCommonInput-IsMandatoryInputJQ" : "" ?>"
                      rows="<?= $textAreaRows ?>"
                      cols="<?= $textAreaCols ?>"
                      maxlength="<?= $textAreaMaxLength ?>"

                      style="
                              min-width: <?= $textAreaMinWidth ?>;
                              max-width: <?= $textAreaMaxWidth ?>;
                              min-height:<?= $textAreaMinHeight ?>;
                              max-height:<?= $textAreaMaxHeight ?>;
                      "
                      <?= $disable ? "disabled" : "" ?>
                      <?= $readonly ? "readonly" : "" ?>
            ><?= htmlspecialchars($value) ?></textarea>
            <?php else: ?>
            <input type="<?= $type ?>"
                   id="<?= $id ?>"
                   value="<?= $value ?>"
                   name="<?= $name ?>"
                   placeholder="<?= $placeholder ?>"
                   class="<?= $isMandatory ? "UICCommonInput-IsMandatoryInputJQ" : "" ?>"
                   <?= $disable ? "disabled" : "" ?>
                   <?= $readonly ? "readonly" : "" ?>
            >
            <?php endif; ?>
            <?php if ($isMandatory): ?>
            <span class="UICCommonInput-Mandatory"> * </span>
            <?php endif; ?>
            <div id="dUICCommonInput-MessageContainer_<?= $id ?>" class="dUICCommonInput-MessageContainerJQ">
                <p> <?= $error ?? "" ?> </p>
            </div>

        </div>
        <?php
    }
    #endregion
}