<?php

use OSM\Frontend\Helpers\Html;

/** @var bool $error */

?>
<div id='login'>
    <form method='post' action='/process-login' id='LoginForm'>
        <div class="text-right">
            <?= Html::submitButton(_d('frontend', 'Login')) ?>
        </div>
        <?php if ($error) { ?>
            <div class="input-wrap text-danger">
                <?= _d('frontend', 'Authorization failed') ?>
            </div>
        <?php } ?>
        <div class='input-wrap'>
            <?= Html::label(_d('frontend', "Username") . ':', ['for' => 'username_input']) ?>
            <?= Html::inputText('username', '', ['id' => 'username_input']) ?>
        </div>
        <div class='input-wrap'>
            <?= Html::label(_d('frontend', "Password") . ':', ['for' => 'password_input']) ?>
            <?= Html::inputPassword('password', '', ['id' => 'password_input']) ?>
        </div>
        <?= Html::a(_d('frontend', "Don't have a team? Register now!"), '/register') ?>
        <?= Html::a(_d('frontend', "Forgot your password?"), '/recover') ?>
    </form>
</div>

