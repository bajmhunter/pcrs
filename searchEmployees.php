<?php //Session is verify, and header is presented. include('includes/_.php'); check_auth(); if ( $_SESSION['access_level'] !=4) {	die('<h1>Unauthorized</h1>');        } $_SESSION['view'] = 'Employees'; get_header(); //This file will display an employee search form.  If the form is submitted, it will //search the database for employees matching the search criteria, and then display //the results. //Function displayResults accepts an sql response object, and uses it to construct //appropriate html output to display its contents. function displayResults($db) {	 		//Head of table displayed.            echo" <h3>Found employees</h3>				<div id='profileBox'></div>				<form action='$PHP_SELF' method='GET'>                <table  align='center' id='employeesTable' class='profile_sect'>                <tr align = 'center'>                <th> &nbsp &nbsp First Name &nbsp &nbsp </th>                <th> &nbsp &nbsp Last Name &nbsp &nbsp </th>                <th> &nbsp &nbsp e-Mail ID &nbsp &nbsp </th>                <th> &nbsp &nbsp Street Address &nbsp &nbsp </th>                <th> &nbsp &nbsp City &nbsp &nbsp </th>                <th> &nbsp &nbsp State &nbsp &nbsp </th>                <th> &nbsp &nbsp Zipcode &nbsp &nbsp </th>                <th> &nbsp &nbsp Access Level &nbsp &nbsp </th>                </tr>				";			//Contents of table diplayed.            $counter=0;            while($rows = $db->result->fetch_assoc())            {                $counter+=1;                echo"                        <tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'                onclick='pageRedirect($counter);'>                            <td>$rows[first_name]</td>                            <td>$rows[last_name]</td>                            <td>&nbsp $rows[email] &nbsp</td>                            <td>$rows[street]</td>                            <td>$rows[city]</td>                            <td>$rows[state]</td>                            <td>$rows[zipcode]</td>							<td>$rows[access_level]</td>                        </tr>                    ";            }			echo" </table></form>"; }?><h1>Employees</h1><?php 	 //If the form was submitted, search for employees matching criteria	 if(isset($_GET['submit1'])) 	 { 		 //Imports variables from the submitted form.		 $first_name = $_GET['firstname'];		 $last_name = $_GET['lastname'];		 $email = $_GET['email'];		 $city = $_GET['city'];		 $state = $_GET['state'];		 $zip = $_GET['zip'];		 //Forms myqsl query to search for customers matching all criteria		 $dataString = "";		 $added = false;		 if($first_name!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."first_name like('%$first_name%')";}		 if($last_name!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."last_name like('%$last_name%')";}		 if($email!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."email like('%$email')";}		 if($city!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."city = like('%$city%')";}		 if($state!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."state = '".$state."'";}		 if($zip!="") {if($added){$dataString=$dataString." and ";} $added=true;$dataString=$dataString."zipcode = '".$zip."'";}		 if($added)		 {			//Executes sql query.			$dataString="where ".$dataString;			$db->runQuery("select first_name,last_name,email,street,city,state,zipcode,access_level from employees $dataString");			if  ($db->result->num_rows > 0)			{				displayResults($db);				$customerFound=1;			}			else			{				echo "<h5>No employees found</h5>";			}		 }     }//The following html code constructs the employee search form.?><h3>Find an employee</h3><div id="customer-search-wrap"><form id="find-employee" ><ul class="search-criteria-list"><li><a href="#details">Details</a><table id="#details" class="table2"><tr><td>First name<td><td><input type="text" class="full" name="firstname"/></td></tr><tr><td>Last name<td><td><input type="text" class="full" name="lastname"/></td></tr><tr><td>Email Address<td><td><input type="text" class="full" name="email"/></td></tr><tr><td>City<td><td><input type="text" class="mid" name="city"/></td></tr><tr><td>State<td><td><input type="text" class="mid" name="state"/></td></tr><tr><td>Zipcode<td><td><input type="text" maxlength="5" size="5" name="zip"/></td></tr><tr><td><input type="submit" value="Search" name="submit1"/></td><td></td></tr></table></li></ul></form></div><?php 	//Adds footer.	get_footer(); ?>