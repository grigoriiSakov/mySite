<?php


namespace SimpleEngine\Controller;
use SimpleEngine\Model\Page;
use SimpleEngine\Model\Comment;
use SimpleEngine\Model\User;

class AdminController extends PageController
{
    public function __construct()
    {
        $this->model = Page::instance();
        $this-> user = new User();
    }

    public function actionIndex()
    {   
        if($this->getUser()->isAdmin()) {
            $articles = $this->model->allPage();
            echo $this->render("index" , array('articles' => $articles));
        }
        else{
            echo $this->render("error");
        }
        
    }

    public function actionEdit($id_article){
        if($this->getUser()->isAdmin()){
            $article = $this->model->getPage($id_article);

            echo $this->render("edit", array('article' => $article));
        }
        else{
            echo $this->render("error");
        }
    }
    
    public  function actionUpdateArticle(){
        if($this->getUser()->isAdmin()){
        if($this->user->isCheckToken('csrf')){
            $delete = $this->model->deletePage();
            if($delete) Comment::instance()->deleteAllComments();
         if($this->model->editPage() ||$delete ) {
             header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index');
         }
        }
        else{
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
        }
        }
        else{
            echo $this->render('error');
        }
    }

    public function actionNewArticle(){
       if($this->user->isAdmin()){
           echo $this->render('newArticle', array('error'=>null, 'content' => null, 'title'=>null));
       }
        else{
            echo $this->render('error');
        }

    }

    public function actionAddArticle(){
        if($this->user->isAdmin() && $this->user->isCheckToken('csrf')){
            $answer = $this->model->addPage();
            if($answer['ok']){
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
            }
            else{
                echo $this->render('newArticle', array('error'=>$answer['error'], 'content' => $_POST['content'],
                    'title'=>$_POST['title']));
            }
        }
        else{
            echo $this->render('error');
        }

    }
    public function actionAddImg(){

// Здесь нужно сделать все проверки передаваемых файлов и вывести ошибки если нужно

// Переменная ответа
        $data = array();
        $error = false;
            $files = array();
            // переместим файлы из временной директории в указанную
            foreach( $_FILES as $file ){
                if(false ){
                    $files[] =$file['name'];
                }
                else{
                    $error = true;
                }
            }

            $data = $error ? array('error_load' => 'Ошибка загрузки файлов.') : array('name' => $files, "host" => "mysite2.dev", 'error_load' =>false );

            echo json_encode( $data );
    }
    public function getModelName()
    {
        return "Admin";
    }
}