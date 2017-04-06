<?php 

class DbDriver{
    
    private $handle;
    private $host;
    private $user;
    private $pass;
    private $base;
    private $last_query_result;
    
    
    function __construct($host, $user, $pass, $base){
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->base = $base;
        $this->connect();
    }
    
    protected function setError($error){
        throw new Exception($error);
    }
    
    protected function connect(){
        $this->handle = @new mysqli($this->host, $this->user, $this->pass, $this->base);
        if($this->handle->connect_errno){
            $this->setError("Nie udalo sie polaczyc z baza danych: ".$this->handle->connect_error);
        }
    }
    
    function runQuery($query){
		$this->handle->query("SET NAMES utf8");
        $this->last_query_result = $this->handle->query($query);
        if(!$this->last_query_result){
            $this->setError("Nie udalo sie wykonac zapytania: ".$this->handle->error);
        }
    }
    
    function getFullList(){
        $return = array();
        while(($row = mysqli_fetch_assoc($this->last_query_result)) !== NULL){
            $return[] = $row;
        }
        
        return $return;
    }
    
    
    function __sleep(){
        return array('host', 'user', 'pass', 'base');
    }
    
    
    function __wakeup(){
        $this->connect();
    }
    
}



?>
















