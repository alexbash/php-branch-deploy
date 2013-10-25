<?php
error_reporting(-1);
ini_set('display_errors', 'On');
set_time_limit(90);

if(!empty($_POST['branch']))
    deleteBranch();
function getBranchesList(){
    if(file_exists('structure')){

        $structure = file_get_contents('structure');
        $lines = explode("\n", $structure);
        $output = array();
        foreach($lines as $line){
            if($line)
            {
                list($branch, $dir) = explode(':', $line);
                if($dir != "")
                    $output[] = $dir;
            }
        }
        return $output;
    }
}

function deleteBranch()
{
    if(file_exists('structure')){
        $contents = file_get_contents('structure');
        $contents = str_replace($_POST['branch'], '', $contents);
        file_put_contents('structure', $contents);
        echo "1";
    }
}
