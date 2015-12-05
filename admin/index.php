<?php
define('ADMIN', __DIR__.'/');

require '../init.inc.php';

$pageCon = Admin_Con::getIns();
$pageCon->show();