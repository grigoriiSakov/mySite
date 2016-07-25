<h4>Страница Администратора</h4>
<a href="/page/index">На главную</a>
<hr>
<h5>Все статьи</h5>
<?php
        foreach ($articles as $article){ ?>
        <p> <?=$article['title'] . ' ' . '<a href="/admin/edit/' .$article['id_article'] .'">править статью</a>    </p>  '      ?>


        <?php }?>
<hr>
<h5><a href="/admin/newArticle">добавить статью</a></h5>


