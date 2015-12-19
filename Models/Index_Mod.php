<?php

/**
* Index_Mod.php: 入口文件index.php 的数据库操作类
*/
class Index_Mod extends Model
{
    protected $table = 'cat';
    protected $result = array();
    public function pageLoad()
    {
        $sql = "select catName, name, Id from $this->table where parentId = 0";
        return $this->result = $this->get_all($sql);

    }

}
