<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

if(file_exists('structure')){
	
	require_once('config.php');
	
	$structure = file_get_contents('structure');
	$lines = explode(PHP_EOL, trim($structure));
	
	$output = array();
	foreach($lines as $line){
		list($branch, $dir) = explode(':', $line);
		echo $dir . '.' . $config['domain'] . '<br />';
	}	
}

?>