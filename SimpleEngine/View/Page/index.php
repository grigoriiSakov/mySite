
<b>Главная</b> |
<a href="/admin/index">Администрирование</a>|
<?php

$name = $this -> getUser() ->getName();
if(!empty($name)) echo '<a href="/page/logout">Выйти</a>' . "<br> Здраствуйте, $name";
else echo '<a href="/page/login">Войти</a>';
?>
<hr/>

<?php
foreach ($articles as $article){ ?>
<section>

    <a href="/page/read/<?=$article['id_article']?>">
        <header> <?=$article['title']?></header>
    </a>
    <?php if($article['img']) echo '<img src="http://' . $_SERVER['HTTP_HOST'] . '/img/' . $article['img']
        . '" alt="' . $article['img'] . '" class = "all_img" width = "350px" height = "250px" >'; ?>
    <article><?=$article['content'] ?></article>
</section>
<?php } ?>

