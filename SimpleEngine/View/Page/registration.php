<?/*
Шаблон регистрации пользователя
===============================


*/?>

<h1>Регистрация</h1>
<?php
if ($reg){
echo '<p> Спасибо за регистрацию, теперь вы можете <a href="/page/login">войти</a>';
}
else {

echo '<p class=error>' . $error . '</p>';

?>
<a href="index.php">Главная</a>
<form method="post" action="/page/AddRegistration">
    Имя: <input type="text" name="name" >
    <br/> <br>
    Логин: <input type="text" name="login"> <br> <br>
    E-mail: <input type="text" name="email" /><br/> <br>
    Пароль: <input type="password" name="password" /><br/> <br>
    Повторите пароль: <input type="password" name="password1" /><br/> <br>
    <input type="submit" value="Зарегистрироваться"/>
    <input type="hidden" name="csrf" value=<?=$this->user->getToken($this->user->getSalt()) ?>
</form>
<?php } ?>