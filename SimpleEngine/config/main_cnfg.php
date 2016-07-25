<?php

//------ VERSION ------

define("APP_VENDOR","SimpleEngine");
define("MIN_PHP_VERSION","5.4");
define("JQUERY_VERSION","jquery-1.9.1");

//------ PHP ------

session_cache_limiter('nocache');
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');

if (version_compare(phpversion(), MIN_PHP_VERSION, "<"))
{
    trigger_error("Current PHP version ".phpversion()." is lower than required ".MIN_PHP_VERSION, E_USER_ERROR);
}

//------ MODULE LOADER ------

require_once $_SERVER['DOCUMENT_ROOT']."/SimpleEngine/Controller/ModuleController.php";

spl_autoload_register('autoload');
function autoload($className)
{
    try{
        $ml = new SimpleEngine\Controller\ModuleController($className);
        $ml->load();

    }
    catch (Exception $e) {
        $e->getMessage();
    }
}

//------ SESSION ------

// В сессии могут храниться объекты, поэтому сессия стартуется после установки autoload
session_start();

//------ GET MODULE FILES ------