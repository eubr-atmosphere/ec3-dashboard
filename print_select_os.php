<?php
    $return_string = "";
    $return_string .= "<select name=\"vmi-fogbow\" id=\"vmi-fogbow\" data-placeholder=\"--Select one--\" style=\"width:350px;\" class=\"chzn-select form-control\" data-validate=\"drop_down_validation\"><option value=\"\"></option>";

    if($_POST)
    {
        $apikey = (isset($_POST['user']) ? $_POST['user'] : "");
        $secretkey = (isset($_POST['pass']) ? $_POST['pass'] : "");
        
        $domain = (isset($_POST['domain']) ? $_POST['domain'] : "");
        $projectID = (isset($_POST['project']) ? $_POST['project'] : "");
        
        exec('python Fogbow_API.py images "' . $apikey . '" "' . $secretkey . '" ' . $domain . ' ' . $projectID, $oss);

		foreach ($oss as $os) {
			$aux = explode(";", $os);
			$name = $aux[0];
			$os = $aux[1];
            $return_string .= "<option value=\"" . $os . "\">" . $name . "</option>";
		}
	}
    $return_string .= "</select>";
    echo $return_string;
?>