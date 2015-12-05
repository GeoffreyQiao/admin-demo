<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - assign()
 * - display()
 * Classes list:
 * - Templates
 */

class Templates
{
  private $values     = array();
  private $proConfigs = array();
  
  function __construct() 
  {
      if (!is_dir(TPL)) {
        mkdir(TPL);
      }
      if (!is_dir(TPL_C)) {
        mkdir(TPL_C);
      }
      if (!is_dir(CACHE)) {
        mkdir(CACHE);
      }
      ob_start();
    
    $tagLib = json_decode( file_get_contents( ROOT . 'config/conf.json' ), true );
    foreach( $tagLib as $k => $v )
    {
      $this->proConfigs[ $k ] = $v;
    }
  }

  function __destruct(){
    $this->proConfigs = array();
  }
  //模板变量注入
  public function assign( $key, $value )
  {
    if( isset( $key ) && !empty( $key ) )
    {
      $this->values[ $key ] = $value;
    } 
    else
    {
      exit( 'ERR: 请设置模板变量！' );
    }
  }
  
  //模板文件显示方法
  public function display( $file )
  {
    if( !file_exists( $tplFile = TPL . $file ) )
    {
      exit( 'ERR: 模板文件不存在!' );
    }
    
    //设置编译文件存放路径
    $parFile   = TPL_C . md5( $file ) . $file . '.php';
    
    //设置缓存文件存放路径
    $cacheFile = CACHE . md5( $file ) . $file . '.html';
    
    /*    如果系统设置缓存开启并且对应缓存文件存在，则判断编译文件和模板文件是否存在并且判断3个关联文件最后修改时间，任一不为true则清空缓存并重新执行编译同时生成缓存文件。否则直接调用缓存静态html文件并返回。
    */
    if(!IS_CACHE)     //是否调用缓存文件的逻辑判断和操作
    {
      ob_end_clean();
    } 
    else
    {
      if(file_exists( $parFile ) && file_exists( $tplFile )  && file_exists($cacheFile) && filemtime( $cacheFile ) >= filemtime( $parFile ) && filemtime( $parFile ) >= filemtime( $tplFile ) )
      {
        require $cacheFile;
        return;
      }
    }
    
    //判断$parFile编译文件不存在或者修改时间小于$filePath的修改时间，将重新编译模板，生产新的编译文件
    if( !file_exists( $parFile ) || filemtime( $parFile ) < filemtime( $tplFile ) )
    {
      require_once ROOT . 'includes/Parser.class.php';
      $parser = new Parser( $tplFile );
      $parser->compile( $parFile );
    }
    include $parFile;
    //获取缓冲区数据并写入新创建的缓存文件
    if (IS_CACHE) {
      file_put_contents( $cacheFile, ob_get_contents());
    }
    return;
  }

}
