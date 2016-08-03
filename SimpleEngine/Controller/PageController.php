<?php


namespace SimpleEngine\Controller;

use SimpleEngine\Model\Page;
use SimpleEngine\Model\Comment;
use SimpleEngine\Model\User;
use SimpleEngine\Model\Images;

class PageController extends BasicController
{
    protected $error_code;
    protected $error_text = "такой страницы не существует";


    

    public function __construct()
    {
        $this->model = Page::instance();
        $this->user = new User();
    }
    public  function __call($name, $arguments)
    {

        echo $this -> render('error');
    }

    // Выводит все статьи на главной
    public function actionIndex(){
        $articles = $this ->model->allPage();
         echo $this->render("index", array('articles'=> $articles));
    }
    // Выводит одну статью и комментарии кней
    public function actionRead($id_article){
        $article = $this -> model -> getPage($id_article);
        if(!$article) echo $this ->render('error');
        $comments = Comment::instance()->allComments($id_article);
        $user_name = '';
        if($this->user->isAuthorized()) $user_name = $this->user->getName();
       echo $this -> render('article', array('article' => $article, 'comments'=>$comments,
                                            'id' => $id_article, 'name'=>$user_name));
    }
    public function actionLogin (){

        echo  $this -> render('login',array(),true );
    }
    public function actionAuthorize(){
       $authorized = $this ->user ->authorize();
        if( $authorized['ok']){
                
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
        }
        else{
            $this->error_text = $authorized['error'];
            echo $this ->render('error');
        }
    }
    public function actionRegistration(){
       echo $this -> render('registration', array('error' => '', 'reg' => false), true);
    }
    public function actionAddRegistration()
    {
        $reg =  $this->user->registration();
        if($reg['ok']){
            echo $this->render('registration', array('reg' => true , 'error' => ''),true);
        }
        else{
           echo $this->render('registration', array('reg' => false, 'error' => $reg['error']),true);
        }
    }
    public function actionLogout (){

        $this->user->lodOut();
        header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
    }
    public function actionAddComment(){
        if($this->user->isCheckToken('csrf')){
            Comment::instance()->addComment();

        }
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }
    public function getModelName()
    {
        return "Page";
    }

    public function getError(){
        return $this->error_text;
    }
    public function getUser(){
        return $this -> user;
    }

}