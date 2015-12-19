<?php

// $option = json_decode(file_get_contents('config/system.json'),true);
// foreach ($option['path'] as $key => $value) {
// 	define($key,$value);
// }


require 'init.inc.php';
$cat = new Cat_Mod();
$rs = $cat->getSource('3');
print_r($rs);
print_r($__GET);
