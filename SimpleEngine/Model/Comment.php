<?php
//
// Менеджер комментариев
//
namespace SimpleEngine\Model;


use SimpleEngine\Controller\DatabaseController;
use SimpleEngine\Controller\RequestController;

class Comment
{
    private static $instance; 	// ссылка на экземпляр класса
    private $msql; 				// драйвер БД

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function instance()
    {
        if (self::$instance == null)
            self::$instance = new Comment();

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
    // Список всех коментариев
    //
    public function allComments($article_id)
    {
        $article_id = (int)$article_id;
        $query = "SELECT * 
				  FROM comment 
				  WHERE article_id=$article_id ORDER BY id_comment DESC";

        return $this->msql->queryFetchAllAssoc($query);
    }

    public function deleteAllComments()
    {
        $result = false;
        if(RequestController::_post('delete','s')=='Удалить'){
            $id_article = RequestController::_post('id_article', 'i');
            $sql = "DELETE FROM comment
                        WHERE `article_id`=:id_article ";
            $params = [
                ':id_article' => $id_article
            ];
            $this->msql->executeQuery($sql, $params);
            $result = true;
        }

        return $result;
    }

    //
    // Добавить коментарий
    //
    public function addComment()
    {
        $result = false;
        // Подготовка.
        $user_name = RequestController::_getpost('user_name','s');
        $content =   RequestController::_getpost('text','s');
        $id =        RequestController::_getpost('id_article', 'i');

        // Проверка.
        if ($user_name != '' && $content!=''){
            // Запрос.
            $date = date('d.m.Y');
            $params =[
                ':id_comment' => null,
                ':article_id' => $id,
                ':c_user' => $user_name,
                ':text' => $content,
                ':c_date' => $date
                ];

            $sql = "INSERT INTO comment (`id_comment`, `article_id`,`user`,`text`,`date`)  
                        VALUES (:id_comment, :article_id, :c_user, :text, :c_date)";


            DatabaseController::connection()->executeQuery($sql, $params);
            $result=true;
        }



        return $result;

    }


}
