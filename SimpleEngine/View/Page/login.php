<?php

$m = $this->getUser();

$html_form = '<form method="post" action="/page/authorize/">';
    $html_form .= '<p>Логин <input type="text" name="login" value=""> </p>';
    $html_form .= '<p>Пароль <input type="password" name="password" value=""></p>';
    $html_form .= '<input type="hidden" name="csrf" value="'.$m->getToken($m->getSalt()).'">';
    $html_form .= '<p>Запомнить <input type="checkbox" name="memory_my" value="1"></p>';
    $html_form .= '<p><input type="submit" name="authorize_me" value="Войти">' ;
    $html_form .= '</form>';


?>

<div class="popup">
    <div class="popup_title">
        <h4>Форма авторизации <span class="closer">X</span></h4>
    </div>
    <div class="popup_content">
        <?= $html_form?>
        <br>
        <br>
        <a href="/page/registration">Зарегистрироваться</a>
        <br>
        <br>
        <a href="/">на главную</a>
    </div>
</div>

