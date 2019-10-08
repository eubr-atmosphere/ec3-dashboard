<?php

include_once('process.php');

// Generates a random string for the name of the cluster
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

//Generates a token calling the Fogbow API
function obtain_token($username, $password, $domain, $projectID){
    $res = ' ';
    exec('python Fogbow_API.py token "' . $username . '" "' . $password . '" ' . $domain . ' ' . $projectID, $token);
    if (count($token) > 0){
        $res = $token[0];
    }
    return $res;
}

if($_POST){
   
    if (isset($_POST['clustername-delete'])) {
        $clustername = $_POST['clustername-delete'];
    } else {
        exit("No clustername parameter specified.");
    }
    
    if (isset($_POST['user-fogbow-delete'])) {
        $username = $_POST['user-fogbow-delete'];
    } else {
        exit("No user parameter specified.");
    }
    
    if (isset($_POST['pass-fogbow-delete'])) {
        $password = $_POST['pass-fogbow-delete'];
    } else {
        exit("No password parameter specified.");
    }
    
    $auth_file = "/tmp/auth_" .$clustername;

    
    /*if (isset($_POST['domain-fogbow-delete'])) {
        $domain = $_POST['domain-fogbow-delete'];
    } else {
        exit("No domain parameter specified.");
    }
    
    if (isset($_POST['project-fogbow-delete'])) {
        $projectID = $_POST['project-fogbow-delete'];
    } else {
        exit("No project ID parameter specified.");
    }*/
    
    //Obtain the token calling the "Fogbow_API" script
    /*$token = obtain_token($user, $pass, $domain, $projectID);
    if ($token == ' '){
        echo 'Found problems trying to obtain a valid token from the server.';
        exit(1);
    }*/
    
    //$clustername = $clustername . "__" . hash('md5', $token);

    /*if($token!=""){
        //$auth_file = "/tmp/auth_" .substr($clustername, 8);
        $auth_file = "/tmp/auth_" .$clustername;
        
        //ahora recuperamos la linea de credenciales del IM
        $im_line="";

        if (file_exists($auth_file)){
            //leemos el antiguo fichero de credenciales
            $file = fopen($auth_file, "r") or exit("Unable to find the old auth file:" . $auth_file . ". Is the cluster name correct?");
            while(!feof($file)){
                $line = fgets($file);
                if(strstr($line, "token")){
                    $token_line = $line;
                    $endpoint = substr($line, strpos($line, "host = ")+7);
                }
                if(strstr($line, "InfrastructureManager")){
                    $im_line=$line;
                }
            }
            fclose($file);
        } else {
            //si no existe el $auth_file, la info del IM se puede sacar de "/var/www/html/.ec3/clusters/" . $clustername
            //en el system front/auth buscar la linea de "type": "InfrastructureManager" y esa es la que tenemos que guardar en $im_line
             $im_username = "";
             $im_pass = "";
             $endpoint = "";
             $file = fopen("/var/www/.ec3/clusters/" . $clustername, "r") or exit("Unable to find the cluster data for cluster:" . $clustername . ". Is the cluster name correct?");
             $logs = fopen("/tmp/temporal_logs.txt", "w");
             while(!feof($file)){
                $line = fgets($file);
                if(strstr($line, "auth")){
                    //coger los datos necesarios del IM, la linea de auth tiene formato JSON
                    $auth_data_json = substr($line, strpos($line, "auth = ")+8, strpos($line, "' and") - (strpos($line, "auth = ")+8));
                    $json_decoded = json_decode($auth_data_json);
                    fwrite($logs, $auth_data_json);
                    //acceder a username y password de im y guardarlo en dos variables
                    for ($i = 0; $i < count($json_decoded); $i++) {
                        if ($json_decoded[$i]->{'type'} == "InfrastructureManager") {
                            $im_username = $json_decoded[$i]->{'username'};
                            $im_pass = $json_decoded[$i]->{'password'};
                        }
                        if ($json_decoded[$i]->{'type'} == "OCCI") {
                            $endpoint = $json_decoded[$i]->{'host'};
                        }
                    }
                    $im_line="type = InfrastructureManager; username = " . $im_username . "; password = " . $im_pass;
                }
	     }
             fclose($file);
             fclose($logs);
         }

        //Y escribimos el nuevo fichero auth
        $gestor = fopen($auth_file, "w");
        fwrite($gestor, "id = fogbow; type = FogBow; host = " . $endpoint . "; token = " . $token . PHP_EOL);
        fwrite($gestor, $im_line. PHP_EOL);
        fclose($gestor);
    } else {
        exit("Error contacting server.");
    }*/

    // llamamos a EC3 para eliminar el cluster
    $ec3_log_file = "/tmp/ec3_del_". $clustername;
    if($auth_file != ""){
        $process_2 = new Process("./command/ec3 destroy --yes --force -a " . $auth_file. " " . $clustername, $ec3_log_file);
    } else {
        $process_2 = new Process("./command/ec3 destroy --yes --force " . $clustername, $ec3_log_file);
    }
    $pid = $process_2->start();
    // Comprobamos si se ha eliminado correctamente
    $status = False;
    while($process_2->status()) {
        sleep(1);
    }

    $log_content = file_get_contents($ec3_log_file);
    if(strpos($log_content, "Error") === False){
        $status = True;
    }
    
    if($status){
	// Esperamos un poco para asegurarnos de borrar el fichero
        sleep(10);
        if (file_exists('/var/www/.ec3/clusters/'. $clustername)) {
            unlink('/var/www/.ec3/clusters/'. $clustername);
        }
        echo "{}";
    } else {
        echo "Problems deleting the cluster. Try again or contact us if the error persists.";
    }
    // TODO: borrar el fichero auth* con las credenciales del usuario del servidor, por cuestiones de seguridad

}else {
    echo "Found errors receiving POST data";
}
?>
