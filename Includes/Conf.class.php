<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - __clone()
* - getIns()
* - __get()
* - __set()
* Classes list:
* - Conf                配置文件操作类
*/
//采用单例模式创建conf的class
class Conf
{
    protected static $ins = null;
    protected $data       = array();
    final protected function __construct()
    {

        //一次性读取配置文件的配置信息赋值给data属性；
        //此处应用绝对路径
        $this->data = new  SimpleXMLElement ( ROOT.'config/conf.xml' ,  NULL ,  TRUE );
    }

    final protected function __clone()
    {
    }

    public static function getIns()
    {
        if( self::$ins instanceof self )
        {
            return self::$ins;
        }
        else
        {
            self::$ins = new self();
            return self::$ins;
        }
    }

    //魔术方法__get获取配置文件内容
    public function __get( $key )
    {
        if( array_key_exists( $key, $this->data ) )
        {
            return $this->data[$key];
        }
        else
        {
            return none;
        }
    }

    //魔术方法__set在运行时动态增改配置文件内容;
    public function __set( $key, $value )
    {
        $this->data[ $key ] = $value;
    }
}

/*
   $conf = conf::getIns();
   print_r($conf);
   echo "<hr/>";
   echo $conf->user,'<br />';
   echo "<hr/>";
   // $conf->template_dir = 'D:/WWW/htdocs';
   // echo $conf->template_dir;
*/
