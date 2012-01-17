<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

require_once('Git/Client.php');
$git = new \Git\Client;

$payload = json_decode($_POST['payload']);
$parts = explode('/', trim($payload->ref));
$ref = end($parts);

$structure = file_get_contents('structure');
$lines = explode(PHP_EOL, trim($structure));

$output = array();
foreach($lines as $line){
	list($branch, $dir) = explode(':', $line);
	if($branch == $ref){
		$dir = dirname(dirname(__FILE__)) . '/' . $dir;
		chdir($dir);
		$output[] = $git->pull($branch);
	}
}

chdir(dirname(__FILE__));
file_put_contents('pulls', print_r($output, true) , FILE_APPEND|LOCK_EX);

?>