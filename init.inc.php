<?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/
header( 'Content-Type:text/html;charset=utf-8' );

define( 'DS', DIRECTORY_SEPARATOR );

define( 'ROOT', __DIR__ . DS );


function __autoload($name){
    $classname = strtolower(substr($name,-3));

    switch ($classname) {
        case 'mod':
            require ROOT . 'Models/' . $name . '.php';
            break;

        case 'vew':
            require ROOT . 'Views/' . $name . '.php';
            break;

        case 'con':
            require ROOT . 'Controlers/' . $name . '.php';
            break;
        
        default:
            if (file_exists($include = ROOT . 'Includes/'. $name . '.class.php')) {
                require_once $include;
            }
            break;
    }
}