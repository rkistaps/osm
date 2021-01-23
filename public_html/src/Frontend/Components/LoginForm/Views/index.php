<?php

use OSM\Frontend\Helpers\Html;

?>
<div id='login'>
    <form method='post' action='' id='loginform'>
        <a class='fb_login' href='#'><img src='/img/html/facebook_login.png' alt=''></a>
        <input type='submit' value='Login' name='login'/>
        <div class='shadows'>
            <label for='username_input'><?= "Username:" ?></label><input id='username_input' name='user' type='text'/>
            <div class='cb'></div>
        </div>
        <div class='shadows'>
            <label for='password_input'><?= "Password:" ?></label><input id='password_input' name='password' type='password'/>
            <div class='cb'></div>
        </div>
        <?= Html::a("Don't have a team? Register now!", '/register') ?>
        <?= Html::a("Forgot your password?", '/recover') ?>
    </form>
</div>

