<?php
include_once('process.php');

//TODO: use clustername not a random string
// Generates a random string for the name of the cluster
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

    
//TODO: obtain user_id to filter the results


// llamamos a EC3 para listar los clusters
$ec3_log_file = "/tmp/ec3_list_".random_string(5);
//$process_2 = new Process("./command/ec3 list -r --json --username " . $user_sub, $ec3_log_file);
$process_2 = new Process("./command/ec3 list -r --json ", $ec3_log_file);

$pid = $process_2->start();
// Comprobamos si se ha listado correctamente
$status = False;

while($process_2->status()) {
    sleep(1);
}

$log_content = file_get_contents($ec3_log_file);
if(strpos($log_content, "Error") === False){
    $status = True;
}

if($status){
    echo $log_content;
} else{
    echo "Problems listing clusters.";
    exit(1);
}

?>
