<?php


namespace SimpleEngine\Controller;

use SimpleEngine\Model\User;

class AppController
{
    private static $instance;

    protected $called_controller = 'Page';
    protected $called_action = 'index';
    protected $generator;
    protected $param;

    protected function __construct()
    {
        $path_data = explode("/", RequestController::_get('path', 's'));
        $this->called_controller = "SimpleEngine\\Controller\\".(!empty($path_data[0]) ? ucfirst($path_data[0]) : "Page")."Controller";
        $this->called_action = (!empty($path_data[1]) ? $path_data[1] : "index");
        $this ->param = isset($path_data[2]) ? $path_data[2] : null;
    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function run(){

            try {
                $this->generator = new $this->called_controller();
            }
            catch (\Exception $e){
                echo 'не пишите ерунду в адресе';
            }
            $method = 'action'.ucfirst($this->called_action);
            $this->generator->$method($this -> param);



    }
}