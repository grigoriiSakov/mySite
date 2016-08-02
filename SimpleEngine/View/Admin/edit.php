<script type="text/javascript" src="http://<?=$_SERVER['HTTP_HOST'] ?>/JS/admin_panel.js"></script>
<a href="/page/index">Главная</a> |
<a href="/admin/index">Панель администратора</a>
<hr/>
<h1>Редактирование статьи</h1>
<br>
<!--ПАНЕЛЬ ББ КОДОВ-->
<span id = "tag_b" style="cursor:pointer;">[b][/b]</span>
&nbsp;&nbsp;
<span id = "tag_a" style="cursor:pointer;">[a][/a]</span>
&nbsp;&nbsp;
<span id = "tag_img" style="cursor:pointer;">[img]</span>
&nbsp;&nbsp;
<span id = "tag_end" style="cursor:pointer;">[end]</span>
<hr>
<!--ПАНЕЛЬ ББ КОДОВ-->
<br>

<form id="admin_form" method="post" action="/admin/updateArticle">
    Название:
    <br/>
    <input type="text" name="title" value="<?=$article['title']?>" />
    <br/>
    <br/>
    Содержание:
    <br/>
    <textarea name="content"><?=$article['content']?></textarea>
<br/>
     <input type="hidden" name="id_article" value="<?=$article['id_article']?>">
    <input type="hidden" name="csrf" value="<?=$this->user->getToken($this->user->getSalt())?>">
    <br>

 
<input class="btn btn-primary" type="submit" name= "save" value="Сохранить" />
<input class="btn btn-danger" type="submit" name=" delete" value="Удалить" />
</form>

<!--ФОРМА [a][/a]-->
<div class="window_tags" id="window_tags_a" style="display:none;">
    <span class = "closer">X</span> <br>
        <div class="input">
        <input id='input_link_a'  type='text' value='Введите адрес ссылки'/>
        <br>
        <br>
        <input id='input_text_a'  type='text' value='Введите текст ссылки'/>
        <br>
        <br>
        <input type="button" id='window_supmit' value="Создать">


    </div>
</div>
<!--ФОРМА [a][/a]-->
<!--ФОРМА [img]-->
<div class="window_tags" id="window_tags_img" style="display:none;">
    <span class = "closer">X</span> <br>
    <p id="error_load" class = "error" style="display:none"></p>
    <div class="input">
        <input id= "file_img" name='file_img' style='width:220px;' type='file'/>
        <input type="hidden" name="csrf" value="<?=$this->user->getToken($this->user->getSalt())?>">
        <br>
        <br>
        <input id="add_img" name="add_img" type="button" value="Добавить">


    </div>
</div>
<!--ФОРМА [img]-->