<?php

class Controller
{
    static public $dataList = array();
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

    protected static function arrList($data){
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    self::$dataList[$value['catName']] = $value['name'];
                }
            }
        }
    }

    public function assign($str,$data){
        self::arrList($data);
        $dataArr = self::$dataList;
        $this->con->assign($str,$dataArr);
        // $this->dataList = $data;
        // foreach ($this->dataList as $k => $v) {
        //     $this->ins->assign('$'.$k,"$v");
        // }
    }


    public function showCat(){
        $name = get_called_class();
        if (isset($_GET["cat"])){
            $this->cat = $_GET['cat'];
        }else {
            $this->cat = substr($name,0,strpos($name, '_Con'));
        }
        $this->con->display($this->cat.'.tpl');
    }

}
