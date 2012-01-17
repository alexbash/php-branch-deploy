<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

require_once('Git/Client.php');
$git = new \Git\Client;

chdir($_POST['directory']);
$checkout = $git->checkout($_POST['branch']);
chdir('../');

$destination = dirname(dirname(__FILE__)) . '/';
$wwwDir = (empty($_POST['altDir'])) ? basename($_POST['branch']) : $_POST['altDir'];
rename($_POST['directory'], $destination . $wwwDir);

$parts = explode('/', $_POST['branch']);
$entry = trim(end($parts), '* ') . ':' . $wwwDir . PHP_EOL;
file_put_contents('structure', $entry , FILE_APPEND|LOCK_EX);

echo json_encode(array('status' => true));

?>