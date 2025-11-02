<?php

use UIC\UICCommonInput\UICCommonInput;
use UIC\UICPasswordInput\UICPasswordInput;

?>
<div class="wrapper-setting-1">
    <div class="container-common-1" style="width: 30em">
        <h1> Login </h1>

        <form action="/user/login" method="post" style="width: 100%; position: relative;">
            <?php
                $errors = $model["errors"] ?? null;
                $uicCommonInput = new UICCommonInput();

                ?>
                <div>
                    <label for="uicComInUsername"> Username </label>
                    <input type="text"
                           id="uicComInUsername"
                           value="<?= $model['username'] ?? '' ?>"
                           name="username"
                           class="input-common-1"
                    >
                </div>

                <div>
                    <label for="uicPass"> Password </label>
                    <input type="password"
                           id="uicPass"
                           value="<?= $model['password'] ?? '' ?>"
                           name="password"
                           class="password_input-common-1"
                    >
                    <span class="spnIcon-dUicInputBox">
                        <img src="<?php echo config("general_config.icon_path") . "eye-off.svg" ?>"
                             alt="eye-outline.svg" class="ibPassShowHideJQ"
                             data-target="uicPass"
                             data-eye-show="eye.svg"
                             data-eye-hide="eye-off.svg"
                             data-icon-path="<?php echo config("general_config.icon_path") ?>"
                        >
                    </span>
                </div>
                <?php
            ?>
            <input type="submit" class="button-common-1" value="Login">
        </form>

        <?php if (isset($model["message"])): ?>
            <div class="message-error-1">
                <p> <?php echo $model["message"] ?> </p>
            </div>
        <?php endif; ?>
    </div>
</div>
