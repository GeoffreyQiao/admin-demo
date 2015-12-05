<?php

class Controller
{
    protected $dataList = array();
    static protected $ins  = null;
    public $con  = null;
    static public $name;
    public $cat;

    /**
     * Index_Con constructor.
     */
    private function __construct()
    {
        $this->con = new Templates();      
    }

    public static function getIns(){
        if (!self::$ins) {
            $className = get_called_class();
            self::$ins = new $className();
        }
        return self::$ins; 
    }
    // protected function assign(){
    //     foreach ($this->dataList as $k => $v) {
    //         $this->ins->assign("$k","$v");
    //     }
    // }
    // public function show(){
    //     static::showPage();
    // }
    // 

    public function show(){
        $name = get_called_class();
        if (isset($_GET["cat"])){
            $this->cat = $_GET['cat'];
        }else {
            $this->cat = substr($name,0,strpos($name, '_Con'));
        }
        return $this->con->display($this->cat.'.tpl');
    }

}