<?php
/**
 * Class and Function List:
 * Function list:
 * - __construct()
 * - parVar()
 * - parIf()
 * - parCommon()
 * - parForeach()
 * - parInclude()
 * - parConfig()
 * - compile()
 * Classes list:
 * - Parser
 */

/**
 * 模板解析类
 */

class Parser
{
  private $tpl     = null;
  private $proVars = array();
  private $parStr =array(
      "parVar"=>array(
        'pStr'=>'/\{\$([\w]+)\}/'
        ),
      "parIf"=>array(
          '/\{if\s*\$([\w]+)\}/'
        )
    );

  function __construct( $tplFile )
  {
    if( !$this->tpl = file_get_contents( $tplFile ) )
    {
      exit( 'ERR: Tpl模板文件读取错误！' );
    }
  }

  //解析普通变量
  private function parVar()
  {
    $pStr = '/\{\s*\$([\w]+)\s*\}/';
    //like: { $var }
    if( preg_match( $pStr, $this->tpl ) )
    {
      $this->tpl = preg_replace( $pStr, "<?php echo \$this->values['$1']; ?>", $this->tpl );
    }
  }

  //解析IF语句
  private function parIf()
  {
    $if     = '/\{\s*if\s*\$([\w]+)\s*\}/';
    //like: { if $var }
    $endIf  = '/\{\s*\/if\s*\}/';
    //like: { /if }
    $else   = '/\{\s*else\s*\}/';
    //like: { else }
    $elseIf = '/\{\s*else\s*if\s+\$([\w]+)\s*\}/';
    //like: { elseif $var }

    if( preg_match( $if, $this->tpl ) )

    //匹配模板中是否含有if的起始部分


    {
      if( preg_match( $endIf, $this->tpl ) )

      //匹配模板中含有if的结束部分


      {
        $this->tpl = preg_replace( $if, "<?php if(\$this->values['$1']){ ?>", $this->tpl );
        $this->tpl = preg_replace( $endIf, "<?php } ?>", $this->tpl );

        if( preg_match( $else, $this->tpl ) )

        //匹配模板中是否含有else部分


        {
          $this->tpl = preg_replace( $else, "<?php }else{ ?>", $this->tpl );
        }

        if( preg_match( $elseIf, $this->tpl ) )

        //匹配模板中的else if部分


        {
          $this->tpl = preg_replace( $elseIf, "<?php }elseif(\$this->values['$1']){ ?>", $this->tpl );
        }
      }
      else
      {
        exit( 'ERR : if语句未关闭！请检查模板错误' );
      }
    }
  }

  //解析注释
  private function parCommon()
  {
      //like: {#"注释"#}
    $pCom = '/\{#(.*)#\}/';
    if( preg_match( $pCom, $this->tpl ) )
    {
      $this->tpl = preg_replace( $pCom, "<?php /* $1 */ ?>", $this->tpl );
    }
  }

  //解析foreach语句
  private function parForeach()
  {
    //like: { foreach $var (string,string) }
    $foreach    = '/\{\s*foreach\s+\$([\w]+)\s+\(\s*@([\w]+),\s*@([\w]+)\s*\)\s*\}/';
    //like: { /foreach }
    $endForeach = '/\{\s*\/foreach\s*\}/';
    //like: {@string}
    $parVar     = '/\{@([\w]+)\s*\}/';

    if( preg_match( $foreach, $this->tpl ) && preg_match( $endForeach, $this->tpl ) )
    {

      //判断foreach语句是否完整，是否正确关闭;

      $this->tpl = preg_replace( $foreach, "<?php foreach(\$this->values['$1'] as \$$2 => \$$3){ ?>", $this->tpl );
      $this->tpl = preg_replace( $endForeach, "<?php } ?>", $this->tpl );

      if( preg_match( $parVar, $this->tpl ) )
      {

        //判断foreach内部是否有内容，有则执行;
        $this->tpl = preg_replace( $parVar, "<?php echo \$$1; ?>", $this->tpl );
      }
    }
  }

  //解析{include}语句
  private function parInclude()
  {
    $include = '/\{include\s+file\s*=\s*(\"|\')([\w\.\-\/]+)(\"|\')\}/';
    //like: {include file = ""}
    if( preg_match( $include, $this->tpl, $file ) )
    {
      if( !file_exists( $file[2] ) || empty( $file ) )
      {
        exit( 'ERR: 包含文件出错！' );
      }
      $this->tpl = preg_replace( $include, "<?php include '$2'; ?>", $this->tpl );
      return true;
  }else {
      return false;
  }
  }

  //解析Config系统变量
  private function parConfig()
  {

    $conStr = '/<!--\{\s*([\w]+)\s*\}-->/';
    if( preg_match( $conStr, $this->tpl ) )
    {
      $this->tpl = preg_replace( $conStr, "<?php echo \$this->proConfigs['$1']; ?>", $this->tpl );
    }
  }

  private function parAction(){

          //解析模板文件
          $this->parInclude();
          $this->parVar();
          $this->parIf();
          $this->parCommon();
          $this->parForeach();
          $this->parConfig();
          if ($this->parInclude()) {
              $this->parAction();
          }

  }
  //主解析方法
  public function compile( $parFile )
  {
    $this->parAction();
    //生成编译文件
    if( !file_put_contents( $parFile, $this->tpl ) )
    {
      exit( 'ERR: Tpl文件编译出错，未成功生成模板编译文件！' );
    }
  }
}
