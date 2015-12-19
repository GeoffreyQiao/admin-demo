<?php

require 'init.inc.php';
$obj = Index_Con::getIns();
$obj->action();
$obj->showCat();
