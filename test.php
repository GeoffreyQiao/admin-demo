<?php

class  A  {
	static $nam = __CLASS__;
    static public function  foo () {
        echo  __CLASS__."<br/>" ;
    }
    public function  test () {
         // $this -> foo ();
        static:: foo ();
    }
}

class  B  extends  A  {
    /* foo() will be copied to B, hence its scope will still be A and
    * the call be successful */
 }

// class  C  extends  A  {
//     self::foo();
// }
 // $a = new A();
 // $a->test();
 $b  = new  B ();
 $b -> test ();
 // $c  = new  C ();
 // $c -> test ();    
 B::foo();
 echo B::$nam;