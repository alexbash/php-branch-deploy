<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

require_once('Git/Client.php');
try
{
    $git = new \Git\Client;
    $repo = 'git@github.com:' . $_POST['repo'];
    $repo = $git->cloneRepo($repo);
    $branches = $git->branches($repo);
    $result = array('status' => 200, 'data' => array(
        'directory' => $repo,
        'branches'  => $branches,
    ));
}
catch(\Git\ClientException $e)
{
    $result = array('status' => 400, 'reason' => $e->getMessage());
}
header('Content-type: application/json');
echo json_encode($result);
exit();