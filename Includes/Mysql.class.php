<?php
/**
* Class and Function List:
* Function list:
* - __construct()
* - __destruct()
* - connect()
* Classes list:
* - Mysqli_Mod extends Db
*/

/**
 * Mysqli_Mod: 封装使用mysqli类来操作数据库
 */
class Mysql extends mysqli
{
    protected $conn = NULL;
    protected $conf = array();
    
    function __construct()
    {
       /* $this->conf = Conf::getIns();*/
       $this->conf = Conf::getIns();
        // $this->connect($this->conf->data['host'], $this->conf->data['user'], $this->conf->data['pswd'], $this->conf->data['dbname'], $this->conf->data['char']);
        
    }
    
    public function __destruct() 
    {
    }
    
/**
 * connect          连接数据库服务器 并 设置字符集
 * @param  [String] $h [description]
 * @param  [String] $u [description]
 * @param  [String] $p [description]
 * @param  [String] $d [description]
 * @return [String]    [description]
 */
    public function connect( $h, $u, $p, $d, $c )
    {
        $this->conn = new mysqli($h, $u, $p, $d);
        if( $this->conn->connect_error )
        {
            $error = ("失败 <<< 数据库连接" );
            throw $error;
        } 
        else
        {
            Log::write( "成功 <<< 数据库连接" );
            $this->conn->set_charset($c);
        }
    }

/**
 * query                                      发送查询语句，并返回结果
 * @param   String      $sql          MySQL查询语句
 * @return    obj          $result      查询结果集
 */
    public function query($sql){
        
        $result = $this->conn->query($sql);

        Log::write( "SQL <<< " . $sql . "\r\n" );
        if( !$result )
        {
            Log::write( "失败 <<< " . $this->conn->error() );
        }
        return $result;
    }

/**
 * getAll           查询多行数据
 * @param       String      $sql        SQL查询语句
 * @return        array       $list        结果集中每一行的集合
 */
    public function getAll( $sql ){
        $result = $this->query($sql);
        $list = array();

        while ($row = $result->fetch_assoc($result)) {
            $list[] = $row;
        }

        return $list;
    }

/**
 * getOne                   查询单个数据
 * @return Int/String   一个值或字符串
 */ 
    public function getOne($sql){

    }

    public function getRow($sql){

    }

/**
 * autoExcute  自动合成并执行insert或者update语句
 * @param  array $arr   参数数组
 * @param  string $table 操作表名称
 * @param  string $mode  insert/update
 * @param  string $where 条件
 * @return [type]        [description]
 */
/*
实现autoExcute('userTable' array('username'=>'zhang','email'=>'123@123.com'),insert);
自动拼接成：
insert into userTable (username,email) values ('zhang','123@123.com');
*/
    public function autoExcute($arr, $table, $mode = 'insert', $where = 'where 1 limit 1'){

        //判断传入$arr查询参数数组是否有效
        if (!is_array($arr)) {
            Log::write( "失败 <<< 未正确传递数组" );
            return false;
        }

        Log::write( "成功 <<< 自动生成SQL语句函数接收参数");

        //判断语句是否为更新查询，如果是则处理并返回
        if ($mode = 'update') {
            $sql = 'update '.$table.' set ';
            foreach ($arr as $key => $value) {
                $sql .= $key . "='".$value."',";
            }
            $sql = rtrim($sql, ',');
            $sql .= $where;
            return $this->query($sql);
        }

        //insert插入查询的sql语句拼接及返回结果
        $sql = 'insert into '.$table.'('.implode('.', array_keys($arr)).')';
        $sql.= ' values (\'';
        $sql.= implode( "','", array_values( $arr ) );
        $sql.= '\')';
        return $this->query($sql);
    }

    public function affected_rows(){
        return $this->conn->affected_rows();
    }
}
