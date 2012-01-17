<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

require_once('Git/Client.php');
$git = new \Git\Client;

$repo = 'git@github.com:' . $_POST['repo'];
$repo = $git->cloneRepo($repo);
$branches = $git->branches($repo);

echo json_encode(array(
	'directory' => $repo,
	'branches'  => $branches,
));

?>