

<a href="/">Главная</a> |
<a href="/admin/index">Администрирование</a>
<hr/>
<h1>Новая статья</h1>
<? if($error) :?>
    <b style="color: red;"> <?=$error?> </b>
<? endif ?>
<form method="post" action="/admin/addArticle">
    Название:
    <br/>
    <input type="text" name="title" value="<?=$title?>" />
    <br/>
    <br/>
    Содержание:
    <br/>
    <textarea name="content"><?=$content?></textarea>
    <br> <br>
    Название картинки к статье(должна быть сохранена в папку img):
    <br/>
    <input type="text" name="file" value="<?=$title?>" />
    <br/> <br>
    <input type="hidden" name="csrf" value="<?=$this->user->getToken($this->user->getSalt()) ?>">
    <input class="btn btn-primary" type="submit" value="Добавить" />
</form>

