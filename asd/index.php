<?php
require "predis/autoload.php";
Predis\Autoloader::register();

$redis = new Predis\Client(array(
 		    "scheme" => "tcp",
		    "host" => "127.0.0.1",
		    "port" => 6379
	));
	echo '<pre>';
print_r($redis->lrange("languages", 0, -1));

echo '</pre>';
?>