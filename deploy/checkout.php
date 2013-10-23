<?php

error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

require_once('Git/Client.php');
try
{
    $git = new \Git\Client;

    if(!is_dir($_POST['directory']))
    {
        throw new \Git\ClientException('Repository directory not exists. Please, try again to clone repository');
    }
    chdir($_POST['directory']);
    $checkout = $git->checkout($_POST['branch']);
    chdir('../');

    $destination = dirname(dirname(__FILE__)) . '/';
    $wwwDir = (empty($_POST['altDir'])) ? basename($_POST['branch']) : $_POST['altDir'];
    if(is_dir($destination.$wwwDir))
    {
        throw new \Git\ClientException('Repository branch already exists');
    }
    rename($_POST['directory'], $destination . $wwwDir);

    $parts = explode('/', $_POST['branch']);
    $entry = trim(end($parts), '* ') . ':' . $wwwDir . PHP_EOL;
    file_put_contents('structure', $entry , FILE_APPEND|LOCK_EX);
    $result = array('status' => 200, 'message' => 'Repository was cloned successfully');
}
catch(\Git\ClientException $e)
{
    $result = array('status' => 400, 'reason' => $e->getMessage());
}
header('Content-type: application/json');
echo json_encode($result);
exit();