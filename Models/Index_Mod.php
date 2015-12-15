<?php

/**
* Index_Mod.php: 入口文件index.php 的数据库操作类
*/
class Index_Mod extends Sqli
{
    private $table = 'cat';
    public function pageLoad()
    {
        $sql = "select catName, name, Id from $this->table where parentId = 0";
        $rs = $this->get_all($sql);
        return $rs;
    }

    public function sourceLoad(){
        $sql = "select ";
    }
}
