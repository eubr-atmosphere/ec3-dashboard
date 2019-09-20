<?php

class Process{
    private $pid;
    private $command;
    private $output_file;

    public function __construct($cl=false, $out_file=false){
        if ($cl != false){
            $this->command = $cl;
        }
	if ($out_file != false) {
            $this->output_file = $out_file;
	} else {
            $this->output_file = tempnam("/tmp", "ec3_");
            unlink($this->output_file);
	}
    }
    private function runCom(){
        $command = 'nohup ' . $this->command . ' > ' . $this->output_file . ' 2>&1 & echo $!';
        exec($command ,$op);
        $this->pid = (int)$op[0];
	return $this->pid;
    }

    public function getOutput(){
	if (is_file($this->output_file)) return file_get_contents($this->output_file);
	else return '';
    }

    public function setPid($pid){
        $this->pid = (int)$pid;
    }

    public function getPid(){
        return $this->pid;
    }

    public function status(){
        $command = '/bin/ps -p '.$this->pid;
        exec($command,$op);
        if (!isset($op[1])) {
		return false;
	} else {
        	return true;
	}
    }

    public function start(){
	$res = NULL;
        if ($this->command != '') $res = $this->runCom();
        return $res;
    }

    public function stop(){
        $command = 'kill '.$this->pid;
        exec($command);
        if ($this->status() == false)return true;
        else return false;
    }
}
?>
