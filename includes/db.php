<?php

/*-----------------------------------
 * @name: Simple Database Interface
 -----------------------------------*/
 
	define('DBNAME','pcrs');
	define('DBUSER','shiftd');
	define('DBPASS','capdata');
	define('DBHOST','localhost');
  define('SITEROOT', 'http://localhost/shiftd/');
	
	class DB{
	
	private $conn;
	public $result;
	//Usage: $conn = new DB()
	
		function __construct(){
			$this->conn =  new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
			
			//debug centric error handling
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
      
			//production error handling
			/*
			if(mqysli_connect_errno()){
				header('Location: http://localhost/shiftd/error.html');
				exit();
			}
			*/
		}
		
		function runQuery($q){
			$this->result = $this->conn->query($q);
			if(!$this->result) {
				printf("<h1>Database Error!: %s</h1>", $this->conn->error); 
        echo $q;
				exit();
			}
		}
		
		
		function __destruct(){
			$this->conn->close();
		}
	}

?>