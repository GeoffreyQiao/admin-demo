<?php

$option = json_decode(file_get_contents('config/system.json'),true);
foreach ($option['path'] as $key => $value) {
	define($key,$value);
}
