<?php
/**
 * Created by PhpStorm.
 * User: apryakhin
 * Date: 06.06.2016
 * Time: 15:57
 */

namespace SimpleEngine\Controller;


abstract class BasicController
{
    protected $model;
    protected $action;
    protected $user;
    
    public function getModel(){
        return $this->model;
    }

    public abstract function getModelName();

    protected function render($method = "index",  $content = array(), $ajax = false){
        if(!$ajax){
            $head = $_SERVER['DOCUMENT_ROOT'] . '/SimpleEngine/View/Header.php';
            $foot = $_SERVER['DOCUMENT_ROOT'] . '/SimpleEngine/View/Footer.php';

            require_once $head;
            
               

                           

            if(file_exists($tpl = $_SERVER['DOCUMENT_ROOT'] . '/SimpleEngine/View/' . $this->getModelName() . '/' . $method . '.php')){
                // Установка переменных для шаблона.
                foreach ($content as $k => $v)
                {
                    $$k = $v;
                }
                ob_start();
                include_once ($tpl);


            }else{
                echo '404 :: Can\'t find '.$this->getModelName() .' '.$method;

            }
            require_once $foot;
            $out = ob_get_contents();
            ob_end_clean();


            return $out;
        }
        else{
            if(file_exists($tpl = $_SERVER['DOCUMENT_ROOT'] . '/SimpleEngine/View/' . $this->getModelName() . '/' . $method . '.php')) {
                $out = include_once($tpl);
                return json_encode($out);
            }
        }
    }
}