<?php  include('includes/_.php');   session_name('PC_Repair_Shop');  session_start();      //if the user is logged in  if(isset($_SESSION['user_name'])){      //check if user is attempting to logout    if( isset($_GET['logout']) ){      //update last_login      $domain = ( $_SESSION['access_level'] < 2 ) ? 'customers' : 'employees';      $id = $_SESSION[ 'user_id'];       $db->runQuery("update $domain set last_access = CURRENT_TIMESTAMP where id = $id;");            session_unset();      session_destroy();      header('Location: '.SITEROOT);      exit();           }        header('Location: '.SITEROOT);    exit();  }  //process login request  //collect login credentials if( isset($_GET['l']) ){	$e = "'".$_GET['e']."'";	$p = "'".$_GET['p']."'";		//try customers first	$db->runQuery("select id,email,password,first_name,last_name, last_access from customers where email = $e and password = $p;");		//try employees next	if($db->result->num_rows == 0){		$db->runQuery("select id,first_name, last_name, email,password, access_level, last_access from employees where email = $e and password = $p;");	}		if($db->result->num_rows == 0){		$_SESSION['msg'] = '<div class="message error">Authorization failed! Incorrect Name/Password combination, Try again</div>';		 header('Location: '.SITEROOT.'auth.php');	}	else{		$record = $db->result->fetch_object();    $_SESSION[ 'user_id' ] = $record->id;		$_SESSION[ 'user_name' ] = $record->email;		$_SESSION[ 'full_name' ] = $record->first_name ." ". $record->last_name;		$_SESSION['access_level'] = isset( $record->access_level ) ? $record->access_level : 1;    $_SESSION['last_access'] = $record->last_access;    unset( $_SESSION['msg'] );		header('Location: '.SITEROOT);	}	 }  //display HTML?><!DOCTYPE html><html><head><link rel="stylesheet" href="assets/css/master.css" /><title>Login</title></head><body id="body"><?php echo $_SESSION['msg'];?><div id="login-div"><h3>LOGIN</h3><form action="<?php printf("%sauth.php",SITEROOT); ?>" method="get"><table cellspacing="0" cellpadding="0"><tr><td><label for="email">Email</label></td><td><input type="text" name="e"/></td></tr><tr><td><label for="password">Password</label></td><td><input type="password" name="p"/></td><tr><td>&nbsp;</td><td><input type="submit" value="Submit" name="l"/></td></tr></table></form></div></body></html>