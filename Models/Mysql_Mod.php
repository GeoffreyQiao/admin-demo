<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - __destruct()
 * - connect()
 * - select_db()
 * - char()
 * - query()
 * - getAll()
 * - getRow()
 * - getOne()
 * - autoExcute()
 * - affected_rows()
 * Classes list:
 * - Mysql_Mod extends Db
 */

/**
 * ClassName: Mysql_Mod
 */
class Mysql_Mod extends Db
{
    private $conn = NULL;
    private $conf = array();
    
    //  析构函数定义私有数据库host、user、password变量
    /*-----------------------------------------*/
    
    public function __construct() 
    {
         //实例化self类
        $this->conf = Conf::getIns();
        
        $this->connect( $this->conf->host, $this->conf->user, $this->conf->pswd );

        //选数据库
        $this->select_db( $this->conf->dbname );
         
        //设置字符编码
        $this->char( $this->conf->char );
        
        
    }
    public function __destruct() 
    {
    }
    
    /*
      connect() 链接服务器
      $h：服务器地址
      $u：用户名
      $p：密码
      return：bool 表示连接数据库成功状态  */
    public function connect( $h, $u, $p )
    {
        $this->conn = mysqli_connect( $h, $u, $p );
        if( !$this->conn )
        {
            $error = new Exception( "失败 <<< 数据库连接" );
            throw $error;
        } 
        else
        {
            Log::write( "成功 <<< 数据库连接" );
        }
    }
    
    //选择数据库
    protected function select_db( $db )
    {
        $sql = 'use ' . $db;
        $this->query( $sql ) ?( Log::write( "成功 <<< 选表" ) ) :( Log::write( "失败 <<< 选表" ) );
    }
    protected function char( $char )
    {
        $sql = 'set names ' . $char;
        return $this->query( $sql ) ?( Log::write( "成功 <<< 编码设置" ) ) :( Log::write( "失败 <<< 编码设置" ) );
    }
    
    /*-------------------------------------------
      发送查询语句
      $sql：select语句/insert语句/update语句...
      return：mixed bool/resource        */
    public function query( $sql )
    {
        $str = mysqli_query( $sql, $this->conn );
        Log::write( " SQL <<< " . $sql . "\r\n" );
        if( !$str )
        {
            Log::write( "失败 <<< " . mysql_error() );
        }
        return $str;
    }
    
    /*-------------------------------------------
      查询多行数据
      $sql：select语句
      return：array/bool                   */
    public function getAll( $sql )
    {
        $result = $this->query( $sql );
        $list = array();
        while( $row = mysql_fetch_assoc( $result ) )
        {
            $list[] = $row;
        }
        return $list;
    }
    
    /*-------------------------------------------
      查询单行数据
      $sql：select语句
      return：array/bool                    */
    public function getRow( $sql )
    {
        $str = $this->query( $sql );
        $row = mysql_fetch_assoc( $str );
        return $row;
    }
    
    /*-------------------------------------------
      查询单个数据
      $sql：select语句
      return：array/bool                     */
    public function getOne( $sql )
    {
    }
    
    /*-------------------------------------------
      自动执行insert/update语句
      $table：被操作的表名
      $data：array()
      $act：insert/update
      $where：update语句执行时的条件
      return：bool
    —————————————————————————————————————
      实现autoExcute('userTable',array('username'=>'zhang','email'=>'123@123.com'),insert);
      自动拼接成：insert into userTable (username,email) values ('zhang','123@123.com');
    */
    public function autoExcute( $arr, $table, $mode = 'insert', $where = ' where 1 limit 1' )
    {
        if( !is_array( $arr ) )
        {
            Log::write( "失败 <<< 未正确传递数组" );
            return false;
        }
        Log::write( "成功 <<< 自动生成SQL语句函数接收参数" );
        if( $mode === 'update' )
        {
            $sql = 'update ' . $table . ' set ';
            foreach( $arr as $k => $v )
            {
                $sql.= $k . "='" . $v . "',";
            }
            $sql = rtrim( $sql, ',' );
            $sql.= $where;
            return $this->query( $sql );
        }
        $sql = 'insert into ' . $table . " (" . implode( ',', array_keys( $arr ) ) . ")";
        $sql.= ' values (\'';
        $sql.= implode( "','", array_values( $arr ) );
        $sql.= '\')';
        
        return $this->query( $sql );
    }
    
    /*-------------------------------------------
    获得受到sql语句执行所影响到的记录数量，用于判断delete方法是否成功
    */
    public function affected_rows() 
    {
        return mysql_affected_rows( $this->conn );
    }
}
