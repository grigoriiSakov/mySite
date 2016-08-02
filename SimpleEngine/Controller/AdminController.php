<?php


namespace SimpleEngine\Controller;
use SimpleEngine\Model\Page;
use SimpleEngine\Model\Comment;
use SimpleEngine\Model\User;
use SimpleEngine\Model\Images;
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

        if($this->user->isAdmin()){
            $answer = Images::instance()->addImage();

        if($answer['ok'] == true){
            $data = array('name' => $answer['file_name'], 'host' => $_SERVER['HTTP_HOST'], 'error_load' => false);
        }
        else{
            $data = array('error_load' => $answer['error']);
        }
            echo json_encode( $data );
        }
        else{
            echo $this->render('error');
        }

    }
    public function getModelName()
    {
        return "Admin";
    }
}