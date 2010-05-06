<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Add Employees';

/*
* Only Manager Can Add Customers
*/
 if ( $_SESSION['access_level'] != 4) {
	die('<h1>Unauthorized</h1>');
 }

 /*
*  Function call to get the navigation menu and header information
*/
get_header();


/*
* If the User has clicked on Submit Button, prepare query and create new customer with the
* posted information.
*/
 if(isset($_POST['submit']))
        {
           $fName = "'".$_POST['fName']."'" ;
           $lName = "'".$_POST['lName']."'" ;
           $eMail = "'".$_POST['eMail']."'" ;
           $street = "'".$_POST['street']."'" ;
           $suite = "'".$_POST['suite']."'" ;
           $city = "'".$_POST['city']."'" ;
           $state = "'".$_POST['state']."'" ;
           $zipCode = $_POST['zipCode'];
           $accessLevel = $_POST['department'] ;
           $password = "'".$_POST['password']."'" ;

            $db->runQuery("insert into employees values (null,$fName,$lName,$eMail,$street,$suite,$city,$state,$zipCode,null,$password,$accessLevel);");
            if($db->result)
            {
                $_SESSION['msg'] = '<div class="message">Offer Created!</div>';
                $customerID = $db->getLastInsertID();
            }

            else
            {
            	$_SESSION['msg'] = '<div class="message error">Offer Creation Failed!</div>';
            }

				$db->runQuery("select * from employees where id = $customerID");
				$rows = $db->result->fetch_object();
				$pdata = json_encode($rows);

			  $db->runQuery(" select id as 'Employee ID', first_name as 'First Name', last_name as 'Last_Name',
					    email as 'E-Mail', street as Street, suite as Suite, city as City, state as State, zipcode as 'Zip Code',
					    access_level as 'Department (2-Employee [Generic], 3-Sales)', last_access as 'Last Accessed On'
					    from employees where id = $customerID ");

           $_SESSION['msg'] = '<div class="message">Offer Created!</div>';
           $columns = $db->result->field_count;

			  echo "
				       <h1> Employee Profile Created! </h1>
				       <div id='profileBox'></div>
				       <ul class='search-criteria-list'>
				           <li><a>Account Details</a>
				               <table class='profile_sect'>
				    ";

			 $i=0;
			 $rows = $db->result->fetch_assoc();
			 while($columns>0)
			 {
				  
				  $fieldHeader = $db->result->fetch_field_direct($i);
				  $fieldName = $fieldHeader->name;
				  
				  echo
				  "<tr>
				      <td class='field'>$fieldName</td> <td>$rows[$fieldName]</td>
				   </tr>";
				   $columns--;
				   $i++;
			 }
			 echo"</li></ul></table></div></body></html>";
			 unset($_SESSION['msg']);
			  }
/*
* If the User has NOT clicked on submit. Show the form to create customers
*/
    else{ ?>

<h1> Add New Employee </h1>
<div id='customer-search-wrap'>
<form id='create-employee' method='POST'>
<ul class='search-criteria-list'>
<li><a>Account Details</a>
<div id="errors"></div>
<table id='#details' class='table2'>
<tr>
<td>First Name</td><td><input type='text' class='mid' name='fName' id="fname"/></td>
</tr>
<tr>
<td>Last Name</td><td><input type='text' class='mid' name='lName' id="lname"/></td>
</tr>
<tr>
<td>Email</td><td><input type='text' class='full' name='eMail' id="email"/></td>
</tr>
<tr>
<td>Confirm email</td><td><input type='text' class='full' name='rEMail' id="email2"/></td>
</tr>
<tr>
<td>Password</td><td><input type='password' class='mid' name='password' id="pass"/></td>
</tr>
<tr>
<td>Confirm Password</td><td><input type='password' class='mid' name='rPassword' id="pass2"/></td>
</tr>
<tr>
<td>Street</td><td><input type='text' class='full' name='street' id="street"/></td>
</tr>
<tr>
<td>Suite</td><td><input type='text' class='mid' name='suite'/></td>
</tr>
<tr>
<td>City</td><td><input name='city' type='text' class='mid' id="city"/></td>
</tr>
<tr>
<td>State</td><td><select name ='state'><optgroup label='U.S. States'>
    <option name='AK' value='AK'>Alaska</option>
    <option name='AL' value='AL'>Alabama</option>
    <option name='AR' value='AR'>Arkansas</option>
    <option name='AZ' value='AZ'>Arizona</option>
    <option name='CA' value='CA'>California</option>
    <option name='CO' value='CO'>Colorado</option>
    <option name='CT' value='CT'>Connecticut</option>
    <option name='DC' value='DC'>District of Columbia</option>
    <option name='DE' value='DE'>Delaware</option>
    <option name='FL' value='FL'>Florida</option>
    <option name='GA' value='GA'>Georgia</option>
    <option name='HI' value='HI'>Hawaii</option>
    <option name='IA' value='IA'>Iowa</option>
    <option name='ID' value='ID'>Idaho</option>
    <option name='IL' value='IL'>Illinois</option>
    <option name='IN' value='IN'>Indiana</option>
    <option name='KS' value='KS'>Kansas</option>
    <option name='KY' value='KY'>Kentucky</option>
    <option name='LA' value='LA'>Louisiana</option>
    <option name='MA' value='MA'>Massachusetts</option>
    <option name='MD' value='MD'>Maryland</option>
    <option name='ME' value='ME'>Maine</option>
    <option name='MI' value='MI'>Michigan</option>
    <option name='MN' value='MN'>Minnesota</option>
    <option name='MO' value='MO'>Missouri</option>
    <option name='MS' value='MS'>Mississippi</option>
    <option name='MT' value='MT'>Montana</option>
    <option name='NC' value='NC'>North Carolina</option>
    <option name='ND' value='ND'>North Dakota</option>
    <option name='NE' value='NE'>Nebraska</option>
    <option name='NH' value='NH'>New Hampshire</option>
    <option name='NJ' value='NJ'>New Jersey</option>
    <option name='NM' value='NM'>New Mexico</option>
    <option name='NV' value='NV'>Nevada</option>
    <option name='NY' value='NY'>New York</option>
    <option name='OH' value='OH'>Ohio</option>
    <option name='OK' value='OK'>Oklahoma</option>
    <option name='OR' value='OR'>Oregon</option>
    <option name='PA' value='PA'>Pennsylvania</option>
    <option name='PR' value='PR'>Puerto Rico</option>
    <option name='RI' value='RI'>Rhode Island</option>
    <option name='SC' value='SC'>South Carolina</option>
    <option name='SD' value='SD'>South Dakota</option>
    <option name='TN' value='TN'>Tennessee</option>
    <option name='TX' value='TX'>Texas</option>
    <option name='UT' value='UT'>Utah</option>
    <option name='VA' value='VA'>Virginia</option>
    <option name='VT' value='VT'>Vermont</option>
    <option name='WA' value='WA'>Washington</option>
    <option name='WI' value='WI'>Wisconsin</option>
    <option name='WV' value='WV'>West Virginia</option>
    <option name='WY' value='WY'>Wyoming</option>
    </optgroup>
    </select>
</tr>

<tr>
<td>Zip Code</td><td><input name='zipCode' type='text' maxlength="6" size="6" id="zip"/></td>
</tr>
<tr>
<td>Access Level</td>
<td><select name='department'/>
	<option name='2' value='2' id='2'>Generic</option>
	<option name='3' value='3' id='3'>Sales</option>
</td>
</tr>
<tr>
<td><input type='submit' value='Create Account' name='submit'></td><td>&nbsp;</td>
</tr>
</table>
</li>
</ul>
</form>
</div>
<script type="text/javascript">

//grab reused html objects
$form = $('#create-employee');
$submit = $('#submit');

//submit gateway
$form.submit( function(){
		if( validate()  ) return true;
		return false;
	}
);


function validate(){

	$errorDiv = $('#errors').toggle();
	var Errors = [];
	//var valid = true;
	var emailPattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	//var url
	$fname  = $('#fname');
	$lname  = $('#lname');
	$email  = $('#email');
	$email2 = $('#email2');
	$pass	  = $('#pass');
	$pass2  = $('#pass2');
	$street = $('#street');
	$city   = $('#city');
	$state  = $('#state');
	$zip    = $('#zip');

	// trim all strings and reset flags
	$('input', $form).removeClass("invalid").each( function(){
		$(this).val( $.trim( $(this).val() ) );
	});
	
	//check name
	if( $fname.val().length < 2){
		Errors.push( '<li>Enter a valid first name<li>' );
		$fname.toggleClass("invalid");
	}
	//check last name
	if( $lname.val().length < 2){
		Errors.push( '<li>Enter a valid last name<li>' );
		$lname.addClass("invalid");
	}

	//check email
	if($email.val().length < 5 || !emailPattern.test($email.val()) ){
		Errors.push('<li>Enter a valid email address<li>');
		$email.addClass("invalid");
		$email2.addClass("invalid");
	}
	else if($email.val() != $email2.val()){
		Errors.push('<li>Emails don\'t match<li>');
		$email.addClass("invalid");
		$email2.addClass("invalid");
	}

	//check password
	var numTest = /[0-9]/;
	var capTest = /[A-Z]/;
	if($pass.val().length < 6 || $pass.val().length > 12  || !numTest.test($pass.val()) || !capTest.test($pass.val()) ){
		Errors.push('<li>Password must contain an uppercase character and a digit and must between 6 and 12 characters long <li>');
		$pass.addClass("invalid");
		$pass2.addClass("invalid");
	}
	else if($pass.val() != $pass2.val()){
		Errors.push('<li>Password fields don\'t match<li>');
		$pass.addClass("invalid");
		$pass2.addClass("invalid");
	}
	
	//check street
	if( $street.val().length < 10){
		Errors.push( '<li>Enter a valid street address<li>' );
		$street.addClass("invalid");
	}
	//check city
	if( $city.val().length < 4){
		Errors.push( '<li>Enter a valid city<li>' );
		$city.addClass("invalid");
	}
	//check zip
	if( $zip.val().length != 5){
		Errors.push( '<li>Enter a valid zipcode<li>' );
		$zip.addClass("invalid");
	}
	
	
	if( Errors.length == 0 ) return true;
	
	$errorDiv.html( '<div class="error-list"><h5>' + Errors.length + ' error(s) encountered!</h5><ul>' + Errors.join('') + '</ul></div>' ).show();
	return false;
}
</script>
<?php
}
get_footer();
?>
