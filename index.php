<?php

// change the following paths if necessary

$config = $_SERVER['DOCUMENT_ROOT'] . '/SimpleEngine/config/main_cnfg.php';

require_once $config;

 $app = \SimpleEngine\Controller\AppController::getInstance()->run();