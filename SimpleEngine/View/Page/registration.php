<?/*
Шаблон регистрации пользователя
===============================


*/?>



    <div class="popup">
        <div class="popup_title">
            <h4>Регистрация  <span class="closer">X</span></h4>
        </div>
        <div class="popup_content">
<?php
if ($reg){
    echo '<p> Спасибо за регистрацию, теперь вы можете <a href="/page/login">войти</a>';
}
else {

    if($error) echo '<p class=error>' . $error . '</p>';

?>
            <form method="post" action="/page/AddRegistration">
                Имя: <input type="text" name="name" >
                <br/> <br>
                Логин: <input type="text" name="login"> <br> <br>
                E-mail: <input type="text" name="email" /><br/> <br>
                Пароль: <input type="password" name="password" /><br/> <br>
                Повторите пароль: <input type="password" name="password1" /><br/> <br>
                <input id="submit_registration" type="button" value="Зарегистрироваться"/>
                <input type="hidden" name="csrf" value=<?=$this->user->getToken($this->user->getSalt()) ?>
                </form>
                <br>
                <?php } ?>
                <a href="index.php">Главная</a>
        </div>
    </div>


