<?php
/**
 * Created by PhpStorm.
 * User: apryakhin
 * Date: 06.06.2016
 * Time: 11:08
 */

namespace SimpleEngine\Model;

use SimpleEngine\Controller\DatabaseController;
use SimpleEngine\Controller\RequestController;

class User
{

    const ADMIN_ROLE_ID = 1;
    //private static $instance = null;
    protected  $id;
    protected  $name;
    protected  $login;
    protected  $action_hash;
    protected  $roles = [];
    protected  $secret;
    protected  $is_authorized = false;

    public function __construct()
    {
        $id= $this->checkCookie() ? $this->checkCookie() : $this->checkSession(); // проверяем не был ли залогинен пользователь

        if($id > 0){
            $sql = "SELECT u.id_user, u.user_name, u.user_login, u.user_action_hash, ur.id_role
                    FROM user u
                    LEFT JOIN user_role ur USING(id_user)
                    WHERE u.id_user = ".(int)$id;
            $user_data = DatabaseController::connection()->queryFetchAllAssoc($sql);
            if(!empty($user_data)){
                $this->name         = $user_data[0]['user_name'];
                $this->login        = $user_data[0]['user_login'];
                $this->action_hash  = $user_data[0]['user_action_hash'];
                $this->is_authorized =true;

                foreach ($user_data as $item){
                    $this->roles[] = $item['id_role'];
                }
            }
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function isAdmin(){
        $result = false;

        if(in_array(self::ADMIN_ROLE_ID, $this->roles))
            $result = true;

        return $result;
    }

    public function getToken($salt){
        $real_ip = (isset($_SERVER['HTTP_X_REAL_IP'])) ? $_SERVER['HTTP_X_REAL_IP'] : "";

        return $salt . ":" . base64_encode($salt . $this->secret . $_SERVER['HTTP_HOST'] . $real_ip);
    }
    public  function isCheckToken($token){
        return $this->checkToken(RequestController::_post($token, 's'));
    }
    public function getSalt(){
        return rand(1000, 9999);
    }
    protected function getIdUserToLogin ($login){
        $t = "SELECT `id_user` FROM user WHERE `user_login` = '%s'";
        $query = sprintf($t, $login);
       return DatabaseController::connection()->queryFetchRowAssoc($query)['id_user'];
    }
    public function isAuthorized (){
        return $this->is_authorized;
    }
    public function registration (){
        $result = [
            'ok'=>0,
            'error' => ''
        ];
        if($this->checkToken(RequestController::_post('csrf', 's'))){
            $password = RequestController::_post('password','s');
            if( $password== RequestController::_post('password1', 's')){
                $email = RequestController::_post('email','email');

                if(!empty($email)){
                    $login = RequestController::_post('login','s');
                    $user_name = RequestController::_post('name','s');
                    if(!$this->getIdUserToLogin($login)){
                        if(!empty($login) && !empty($user_name)){
                            $params =[
                                ':id_user' => null,
                                ':user_login' => $login,
                                ':user_name' => $user_name,
                                ':email' => $email,
                                ':user_pass_hash' => $this->getPasswordHash($password),
                                ':user_action_hash' => $this->getUserActionHash(),
                                'user_session' => session_id(),
                                'user_last_action' => time()
                            ];
                            $sql = "INSERT INTO user (`id_user`, `user_login`,`user_name`,
                                `email`, `user_pass_hash`, `user_action_hash`, `user_session`, `user_last_action`)
                        VALUES (:id_user, :user_login, :user_name, :email, :user_pass_hash,
                         :user_action_hash, :user_session, :user_last_action)";
                            DatabaseController::connection()->executeQuery($sql, $params);

                            $params =[
                                ':id_user_role' => null,
                                ':id_user' => $this->getIdUserToLogin($login),
                                ':id_role' => '2'
                            ];

                            $sql = "INSERT INTO user_role (`id_user_role`,`id_user`, `id_role`)
                                VALUES (:id_user_role, :id_user, :id_role)";
                            DatabaseController::connection()->executeQuery($sql, $params);
                            $result['ok']=true;
                    }
                        else $result['error']= 'все поля формы должны быть заполнены';
                    }

                    else $result['error'] = 'пользователь с таким логином уже зарегистрирован';

                }
                else $result['error'] = 'Не правильно указан е-майл';

            }
            else{
                $result['error'] = 'пароли не совпадают';
            }


        }
        return $result;
        
    }
    public function authorize(){
        $result = [
            'ok' => 0,
            'error' => ''
        ];

        if($this->checkToken(RequestController::_post('csrf', 's'))){
            if($this->checkAuthPair(RequestController::_post('login', 's'), RequestController::_post('password', 's'))){
                $result['ok'] = 1;
                $this->updateUserActionHash();

                // авторизация прошла

                    $sql = "UPDATE `user`
                        SET user_session = :session_id
                        WHERE id_user = :id_user ";
                $params = [
                    ':session_id' => session_id(),
                    ':id_user' => $this->id
                ];

                DatabaseController::connection()->executeQuery($sql, $params);
                if(RequestController::_getpost('memory_my')==='1'){
                    setcookie("user_id",$this->id, time() + 3600*24*7, '/' );
                    setcookie("user_action_hash", $this->action_hash, time() + 3600*24*7, '/');
                }
                else{
                    $_SESSION ['user_id'] = $this->id;

                    
                }



                $this->is_authorized = true;

            }
            else{
                $result['error'] = "Неверный логин/пароль";
            }
        }
        else{
            $result['error'] = 'Не удалось авторизоваться '.$_POST['csrf'];
        }

        return $result;
    }

    public function lodOut (){
            setcookie('user_id', '', time() - 3600,'/');
            setcookie('user_action_hash', '', time() - 3600,'/');
            unset($_COOKIE['user_id']);
            unset($_COOKIE['user_action_hash']);
            unset($_SESSION['user_id']);
            unset($_SESSION['user_action_hash']);
            $this->id = null;
            $this->login = null;
            $this->name = null;
            $this->action_hash = null;
            $this->roles = [];


    }

    protected function checkAuthPair($login, $password){
        $result = false;

        $request_data = [
            ':user_login' => $login
        ];

        $origin = DatabaseController::connection()->getDataRowByRequest("SELECT id_user, user_login, user_pass_hash 
										from user
										where user_login = :user_login", $request_data);

        if($this->getPasswordHash($password) == $origin['user_pass_hash']){
            $result['ok'] = true;
            $this->id = $origin['id_user'];


        }

        return $result;
    }

    protected function checkToken($token){
        $check = false;

        $token_parts = explode(":", $token);
        if($this->getToken($token_parts[0]) == $token){
            $check = true;
        }

        return $check;
    }

    protected function getPasswordHash($password){
        return md5($password);
    }

    protected function updateSecret(){
        $this->secret = uniqid();
        $_SESSION['secret'] = $this->secret;
    }

    protected function getUserActionHash (){
        $real_ip = (isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : "");
        return md5(session_id() . $_SERVER['HTTP_HOST'] . $real_ip);
    }

    protected function updateUserActionHash(){
         $this->action_hash= $this->getUserActionHash();
           $sql = "UPDATE `user` SET user_action_hash = :user_action_hash, user_last_action = :user_last_action
                        WHERE id_user = :id_user ";
        
        $params = [
            ':user_action_hash' => $this->action_hash,
            ':user_last_action' => time(),
            ':id_user' => $this->id
        ];

        DatabaseController::connection()->executeQuery($sql, $params);

    }

    protected function checkCookie(){
        $result = 0;

        if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_action_hash'])){
            // проверяем соответствие user_id и user_action_hash
            $origin = DatabaseController::connection()
                ->getDataRowByRequest("SELECT user_action_hash 
										from user
										where id_user = :id_user", [":id_user" => $_COOKIE['user_id']]);

            if($origin['user_action_hash'] == $_COOKIE['user_action_hash']){
                $this->id = $_COOKIE['user_id'];
                $result = $this->id;
            }
        }
        return $result;
    }

    protected function checkSession(){
        $result = 0;
        $session = RequestController::_session('user_id','s');
        if($session){
            // проверяем соответствие user_id и user_action_hash
            $origin = DatabaseController::connection()
                ->getDataRowByRequest("SELECT user_session 
										from user
										where id_user = :id_user", [":id_user" => RequestController::_session('user_id','s')]);

            if($origin['user_session'] == session_id()){
                $this->id = RequestController::_session('user_id','s');
                $result = $this->id;
            }
        }
        return $result;
    }


}