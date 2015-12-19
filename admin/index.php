<?php
define('ADMIN', __DIR__.'/');

require '../init.inc.php';
$turnOnCache = false;
$pageCon     = Admin_Con::getIns();
$pageCon->showCat();
echo IS_CACHE;