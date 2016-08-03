
<b>Главная</b> |
<a href="/admin/index">Администрирование</a>|
<?php

$name = $this -> getUser() ->getName();
if(!empty($name)) echo '<a href="/page/logout">Выйти</a>' . "<br> Здраствуйте, $name";
else echo ' <span id="login">Войти</span>';
?>
<hr/>

<?php
foreach ($articles as $article){ ?>
<section>

    <a href="/page/read/<?=$article['id_article']?>">
        <header> <?=$article['title']?></header>
    </a>

    <article><?=$article['content'] ?></article>
</section>
<?php } ?>
<div class="login"></div>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'] ?>/JS/login.js"></script>