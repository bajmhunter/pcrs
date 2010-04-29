<?php  define('SITEROOT', 'http://localhost/pcrs/');    //database config 	define('DBNAME','pcrs');	define('DBUSER','shiftd');	define('DBPASS','capdata');	define('DBHOST','localhost');	  /*---------------------------------------------------------    @name:    DB    @purpose: A simple mysqli database wrapper  ---------------------------------------------------------*/	class DB{		private $conn;	public $result;	    function __construct(){      $this->conn =  new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);            //debug centric error handling      if (mysqli_connect_errno()) {        printf("Connect failed: %s\n", mysqli_connect_error());        exit();      }            //production error handling      /*      if(mqysli_connect_errno()){        header('Location: http://localhost/shiftd/error.html');        exit();      }      */    }		    function runQuery($q){      $this->result = $this->conn->query($q);      if(!$this->result) {        printf("<h1>Database Error!: %s</h1>", $this->conn->error);         echo $q;        exit();      }    }  	function escape($str){		return $this->conn->real_escape_string($str);	}	    function __destruct(){      $this->conn->close();    }    function getLastInsertID(){	//return $this->insert_id;	return $this->conn->insert_id;}  }	$db = new DB(); //reference with global $db      /*---------------------------------------------------------    @name:    check_auth    @purpose: Ensure that the current session is authicated  ---------------------------------------------------------*/  function check_auth(){    session_name('PC_Repair_Shop');    session_start();    if( !isset($_SESSION['user_id']) ){      header('Location: '.SITEROOT.'auth.php');    }  }	  /*---------------------------------------------------------    @name:    update_last_access    @purpose: Updates a user's last access timestamp  ---------------------------------------------------------*/  function update_last_access(){    $domain = ( $_SESSION['access_level'] < 2 ) ? 'customers' : 'employees';    $id = $_SESSION[ 'user_id'];     $db->runQuery("update $domain set last_access = CURRENT_TIMESTAMP where id = $id;");  }	  /*------------------------------------------------------------    @name:    get_header    @purpose: returns an access level aware navigation menu  ------------------------------------------------------------*/	function get_header(){		include('chunks/header.php');	}	  /*------------------------------------------------------------    @name:    get_footer    @purpose: returns the footer  ------------------------------------------------------------*/	function get_footer(){		echo '</div><div id="bottom">			&copy; 2010 PC Repair Shop			</div>			</body>			</html>';	}	  /*------------------------------------------------------------    @name:    get_msg    @purpose: display the user message   ------------------------------------------------------------*/  function get_msg(){    if(isset($_SESSION['msg'])) echo $_SESSION['msg'];    unset( $_SESSION['msg'] );  }    /*------------------------------------------------------------    @name:    mysql_to_date    @purpose: convert a mysql time stamp and possibly date to              the desired output format  ------------------------------------------------------------*/  function mysql_to_date( $str ){    return strftime('%a %d %b %Y', strtotime($str) );  }?>