<?php
/**
 * Created by PhpStorm.
 * User: apryakhin
 * Date: 06.06.2016
 * Time: 15:50
 */

namespace SimpleEngine\Model;


use SimpleEngine\Controller\DatabaseController;
use SimpleEngine\Controller\RequestController;

class Page
{
    private static $instance; 	// ссылка на экземпляр класса
    private $msql; 				// драйвер БД

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function instance()
    {
        if (self::$instance == null)
            self::$instance = new Page();

        return self::$instance;
    }

    //
    // Конструктор
    //
    private function __construct()
    {
        $this->msql = DatabaseController::connection();
    }

    //
    // Список всех статей
    //
    public function allPage()
    {
        $all_page = array();
        $query = "SELECT * 
				  FROM article 
				  ORDER BY id_article DESC";
        $all_page=$this->msql ->queryFetchAllAssoc($query);
        foreach ($all_page as $key => $page){
            $all_page[$key]['content'] = $this->addBb($page['content']);
        }
        return $all_page;
    }

    //
    // Конкретная статья
    //
    public function getPage($id_article, $to_edit=false)
    {
        // Запрос.
        $t = "SELECT * 
			  FROM article 
			  WHERE id_article = '%d'";
        $query = sprintf($t, $id_article);
        $result = $this->msql->queryFetchRowAssoc($query);
        if(!$to_edit) $result['content'] = $this->addBb($result['content'],false);
        return $result;
    }

    //
    // Добавить статью
    //
    public function addPage()
    {
        $result = [ 'ok' => false,
            'error' => ''];
        // Подготовка.
        $title = RequestController::_post('title','s');
        $content = RequestController::_post('content', 's');
        $img_name = RequestController::_post('file', 's');
        if ($title){
            if ($content){
                // Запрос.
               $params = [
                ':title' => $title,
                ':content' => $content,
                   ':img' => $img_name
            ];
                $sql = " INSERT INTO article  (`title`,`content`,`img`) VALUES (:title, :content,:img)";
                $this->msql->executeQuery($sql, $params); 
                $result['ok'] = true;
            }
            else{
                $result['error'] = 'Не заполнен текст статьи';
            }                   
        }
         else{
             $result['error'] = 'Не заполнен заголовок';
         }   

        
        
        return $result;
    }

    //
    // Изменить статью
    //
    public function editPage()
    {

        $result = false;
       if(RequestController::_post('save','s') == 'Сохранить') { // Подготовка.
           $title = RequestController::_post('title');
           $content = RequestController::_post('content', 's');
           $id_article = RequestController::_post('id_article', 'i');
            $img_name = RequestController::_post('file', 's');
           // Проверка.
           if ($title) {

               // Запрос.

               $sql = "UPDATE article
                        SET `title`=:title, `content`=:content, `img` = :img
                        WHERE `id_article`=:id_article ";
               $params = [
                   ':title' => $title,
                   ':content' => $content,
                    ':id_article' => $id_article,
                   ':img' => $img_name
               ];
               $this->msql->executeQuery($sql, $params);
               $result = true;
           }
       }
        return $result;
    }

    //
    // Удалить статью
    //
    public function deletePage()
    {
        $result = false;
        if(RequestController::_post('delete','s')=='Удалить'){
            $id_article = RequestController::_post('id_article', 'i');
            $sql = "DELETE FROM article
                        WHERE `id_article`=:id_article ";
            $params = [
                ':id_article' => $id_article
            ];
            $this->msql->executeQuery($sql, $params);
            $result = true;
        }

        return $result;
    }
    protected function addBb($var, $preview = true) {

        $search = array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[img (\S*)\]/is',
           '/\[a url=(.*)\](.*)\[\/a\]/is'
        );

        $replace = array(
            '<strong>$1</strong>',
            '<img src=$1 />',
            '<a href=$1>$2</a>'
        );


        $var =  preg_replace ($search, $replace, $var);
        if($preview) {
            $var = explode('[end]',$var)[0];
        }
        else{

            $var = str_replace('[end]',"", $var);
        }
        return(nl2br($var));
    }
    // Короткое описание статьи
//
    static  public  function articlesIntro($article, $col)
    {
        return  mb_substr($article['content'], 0, $col, 'UTF-8') . '...';

    }
}