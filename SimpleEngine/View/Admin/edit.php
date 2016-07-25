
<a href="/page/index">Главная</a> |
<a href="/admin/index">Панель администратора</a>
<hr/>
<h1>Редактирование статьи</h1>

<form class="form-group" method="post" action="/admin/updateArticle">
    Название:
    <br/>
    <input type="text" name="title" value="<?=$article['title']?>" />
    <br/>
    <br/>
    Содержание:
    <br/>
    <textarea name="content"><?=$article['content']?></textarea>
<br/>
    <input type="text" name="file"value="<?=$article['img']?>" />
    <input type="hidden" name="id_article" value="<?=$article['id_article']?>">
    <input type="hidden" name="csrf" value="<?=$this->user->getToken($this->user->getSalt())?>">
    <br>

 
<input class="btn btn-primary" type="submit" name= "save" value="Сохранить" />
<input class="btn btn-danger" type="submit" name=" delete" value="Удалить" />
</form>