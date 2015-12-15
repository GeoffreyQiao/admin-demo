<?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/
header( 'Content-Type:text/html;charset=utf-8' );

define( 'DS', DIRECTORY_SEPARATOR );

define( 'ROOT', __DIR__ . DS );

//模板目录
define( 'TPL', ROOT . 'templates' . DS );

//编译文件目录
define( 'TPL_C', ROOT . 'templates_c' . DS );

//静态页面缓存文件目录
define( 'CACHE', ROOT . 'cache' . DS );

//模板缓存开关
// $turnOnCache = true;       //true or false
// if (defined('ADMIN')) {
    define('IS_CACHE', false);
// }else {
//     define('IS_CACHE', $turnOnCache);
// }


function __autoload($name){
    $className = strtolower(substr($name,-3));

    switch ($className) {
        case 'mod':
            require ROOT . 'Models/' . $name . '.php';
            break;

        case 'vew':
            require ROOT . 'Views/' . $name . '.php';
            break;

        case 'con':
            require ROOT . 'Controllers/' . $name . '.php';
            break;

        default:
            if (file_exists($include = ROOT . 'Includes/'. $name . '.class.php')) {
                require_once $include;
            }
            break;
    }
}
