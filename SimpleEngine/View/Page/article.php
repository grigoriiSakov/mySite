<?php
/* шаблон для вывода статьи*/
?>
<a href="/">Главная</a>

<hr/>

<?php $m= $this->user;?>
<section>

    <header> <?=$article['title']?> </header>
    <?php if($article['img']) echo '<img src="http://'. $_SERVER['HTTP_HOST'] . '/img/' . $article['img']
        . '" alt="' . $article['img'] . '" class = "one_img">'; ?>
    <article><?=$article['content'] ?></article>
    <br>
    <section class=comment>
        <h3>Комментарии</h3>
        <hr>

        <?php foreach ($comments as $comment) {?>



        <h5> <?=$comment['user']?> </h5>
        <p><?=$comment['text'] ?></p>
        <span><?=$comment['date']?></span>
        <hr>

        <?php }?>

    </section>

    <hr/>

    <?php
    if($name) {?>
    <h3>Добавить комментарий</h3>
    <form method="post" action = "/page/addComment">
    <input type="hidden" name="csrf" <?='value='. $m->getToken($m->getSalt())?>>
    Вы вошли как: <?=$name?> | <a href="/page/logout">Выйти</a> <br>

    Текст комментария:
    <br/>
    <textarea name="text"></textarea>
    <br/>
    <input class="btn btn-primary"  type="submit" value="Добавить" />
    <input type="hidden" name="id_article" value= "<?=$id?>">
    <input type="hidden" name="user_name" value= "<?=$name?>">
    </form>
    <?}
else{ ?>
    <h4>Вы должны войти, чтобы оставить комментарий</h4>
    <a id="login" href="#">Войти</a>
    <?}?>


    </div>
</section>
<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'] ?>/JS/login.js"></script>