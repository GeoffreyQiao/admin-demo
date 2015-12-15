<?php

    class Index_Con extends Controller
    {
        protected $rs = array();

            public function action(){
                $db = new Index_Mod();
                $this->rs = $db->pageLoad();
                $this->assign('cat',$this->rs);
            }

    }
