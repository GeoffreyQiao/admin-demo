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

  protected function whichFileShow($tplFile,$parFile,$cacheFile){
      if (IS_CACHE) {
          ob_start();//开启缓冲区
          if (file_exists($tplFile) && file_exists($parFile) && file_exists($cacheFile))
          //模板文件，编译文件，缓存文件都存在
           {
              if (filemtime( $cacheFile ) >= filemtime( $parFile ) && filemtime( $parFile ) >= filemtime( $tplFile ) && filesize($cacheFile)>0)
              //模板文件，编译文件，缓存文件的修改时间依次较晚
              {
                  ob_clean();
                  return $cacheFile;
              }
          }
          $parPage = $this->makePar($tplFile,$parFile);
          require $parPage;
          file_put_contents( $cacheFile, ob_get_contents());
          ob_clean();
          return $cacheFile;
      }else{
          return $this->makePar($tplFile,$parFile);
      }
  }

  protected function makePar($tplFile,$parFile){
      $parser = new Parser( $tplFile );
      $parser->compile( $parFile );
      return $parFile;
  }
  //模板文件显示方法
  /**
   * @param $file
   */
  public function display($file )
  {
    if( !file_exists( $tplFile = TPL . $file ) )
    {
      exit( 'ERR: 模板文件不存在!' );
    }

    //设置编译文件存放路径
    $parFile   = TPL_C . md5( $file ) . $file . '.php';

    //设置缓存文件存放路径
    $cacheFile = CACHE . md5( $file ) . $file . '.html';

    $file = $this->whichFileShow($tplFile,$parFile,$cacheFile);
    require $file;
    return;
  }

}
