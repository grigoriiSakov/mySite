<?php


namespace SimpleEngine\Controller;


class ModuleController
{
    protected $rootPath; // путь до проекта
    protected $className;

    function __construct($className)
    {
        $this->className = $className;
        $this->rootPath = $_SERVER['DOCUMENT_ROOT'];
    }

    public function load()
    {
        $file = null;
        $tmp_path_array = explode("\\", $this->className);
        $vendor = $tmp_path_array[0];
        $type = $tmp_path_array[1];
        $class = $tmp_path_array[2];

        if($vendor == APP_VENDOR && file_exists( $_SERVER['DOCUMENT_ROOT'] . "/" . $vendor. "/" .$type. "/" . $class . '.php' )) {
            // calling controller
            $file = $_SERVER['DOCUMENT_ROOT'] . "/" . $vendor . "/" . $type . "/" . $class . '.php';

            require_once $file;
        }
        else {
            throw new \Exception("Can't load " . $_SERVER['DOCUMENT_ROOT'] . "/" . $vendor . "/" . $type . "/" . $class . '.php');
        }
    }
}