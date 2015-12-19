<?php
/**
* Class and Function List:
* Function list:
* Classes list:
*/
//设定默认页面类型、字符集
header( 'Content-Type:text/html;charset=utf-8' );

//设置默认时区为PRC（中国）
date_default_timezone_set('PRC');

//定义DS代表系统默认分隔符"\"或者"/"
define( 'DS', DIRECTORY_SEPARATOR );

//定义项目基础路径
define( 'ROOT', __DIR__ . DS );

//模板目录
define( 'TPL', ROOT . 'templates' . DS );

//编译文件目录
define( 'TPL_C', ROOT . 'templates_c' . DS );

//静态页面缓存文件目录
define( 'CACHE', ROOT . 'cache' . DS );

//模板缓存开关
$turnOnCache = false;       //true or false
// if (defined('ADMIN')) {
define('IS_CACHE', $turnOnCache);
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
require_once 'Includes/Lib_base.php';
$_GET  = _AddSlashes($_GET);
$_POST = _AddSlashes($_POST);