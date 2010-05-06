<?php
 include('includes/_.php');
 check_auth();
/*
* Only Manager Can edit Employees
*/
    if ( $_SESSION['access_level'] != 4) {
	die('<h1>Unauthorized</h1>');
        }

        get_header();

        $empID = $_GET['empID'];
        
/*
 * If the user has Clicked the update button, prepare the query and update records based on the
 * values posted
 */
        if( $_GET['action'] == 'Update' )
        {
            $fName = $_GET['first_name'];
            $lName = $_GET['last_name'];
            $eMail = $_GET['email'];
            $street = $_GET['street'];
            $suite = $_GET['suite'];
            $city = $_GET['city'];
            $zipCode = $_GET['zipcode'];
            $state = $_GET['state'];
            $empiD = $_GET['id'];
            $db->runQuery("update employees set first_name = '$fName',last_name = '$lName',email = '$eMail',
                    street = '$street',suite = '$suite',city = '$city',state = '$state',
                    zipcode = '$zipCode' where id = $empiD;");
            if($db->result)
            {
                $_SESSION['msg'] = '<div class="message">Employee Profile Updated!</div>';
                $empID = $empiD;
            }

            else
            {
                    $_SESSION['msg'] = '<div class="message error">Employee Profile Update Failed!</div>';
            }
        }


        $db->runQuery("select id,first_name,last_name,email,street,suite,city,state,zipcode,access_level,last_access
            from employees where id = $empID");
        $rows = $db->result->fetch_object();
        $pdata = json_encode($rows);

      


 ?>

        <h1 id="profile-h1"> <a href="#" id="edit-profile-link">Edit</a></h1>
        <div id="profileBox"></div>
<!--
JavaScript to toggle display between Edit and Cancel Views to update the customer profile.
-->
<script type="text/javascript">

showMsg('<?php get_msg(); ?>');

var pdata = <?php echo $pdata; ?>;

var html = '';
var formhtml = '';

$('#profile-h1').prepend('Employee ID: ',pdata['id']);

var str= ['<h3>Employee Profile Information</h3><table class="profile_sect">'];
var st2= ['<h3>Edit Account Information</h3><form><table class="profile_sect">'];

function nonEditable(keye){
    str.push('<tr><td class="field">',keye.capitalize(),'</td><td>',pdata[keye],'</td></tr>');
    st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text disabled="disabled" name=',keye,' value="',pdata[keye],'"/></td></tr>');

}
function nonEditableID(keye){
  str.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
  st2.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td><td><input type=text disabled = "disabled" name=',keye,' value="',pdata[keye],'"/></td></tr>');
}

function editableID(keye){
    if(keye=='access_level')
        {
            str.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td><td><select name=',keye,'>\n\
                <option name=\'2\' value = \'2\'>Employee [Generic]</option><option name=\'3\' value = \'3\'>Sales Person</option><option disabled ="disabled">Manager</td></tr>');
        }
        else
        {
          str.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
          st2.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');
        }
}

function editable(keye){
    if(keye=='zipcode')
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type="text" maxlength = 5 name=',keye,' value="',pdata[keye],'"/></td></tr>');
    }
    else if(keye=='state')
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><select name=',keye,'><optgroup label=\'U.S. States\'>\n\
<option name=\'AK\' value=\'AK\'>Alaska</option>\n\
<option name=\'AL\' value=\'AL\'>Alabama</option>\n\
<option name=\'AR\' value=\'AR\'>Arkansas</option>\n\
<option name=\'AZ\' value=\'AZ\'>Arizona</option>\n\
<option name=\'CA\' value=\'CA\'>California</option>\n\
<option name=\'CO\' value=\'CO\'>Colorado</option>\n\
<option name=\'CT\' value=\'CT\'>Connecticut</option>\n\
<option name=\'DC\' value=\'DC\'>District of Columbia</option>\n\
<option name=\'DE\' value=\'DE\'>Delaware</option>\n\
<option name=\'FL\' value=\'FL\'>Florida</option>\n\
<option name=\'GA\' value=\'GA\'>Georgia</option>\n\
<option name=\'HI\' value=\'HI\'>Hawaii</option>\n\
<option name=\'IA\' value=\'IA\'>Iowa</option>\n\
<option name=\'ID\' value=\'ID\'>Idaho</option>\n\
<option name=\'IL\' value=\'IL\'>Illinois</option>\n\
<option name=\'IN\' value=\'IN\'>Indiana</option>\n\
<option name=\'KS\' value=\'KS\'>Kansas</option>\n\
<option name=\'KY\' value=\'KY\'>Kentucky</option>\n\
<option name=\'LA\' value=\'LA\'>Louisiana</option>\n\
<option name=\'MA\' value=\'MA\'>Massachusetts</option>\n\
<option name=\'MD\' value=\'MD\'>Maryland</option>\n\
<option name=\'ME\' value=\'ME\'>Maine</option>\n\
<option name=\'MI\' value=\'MI\'>Michigan</option>\n\
<option name=\'MN\' value=\'MN\'>Minnesota</option>\n\
<option name=\'MO\' value=\'MO\'>Missouri</option>\n\
<option name=\'MS\' value=\'MS\'>Mississippi</option>\n\
<option name=\'MT\' value=\'MT\'>Montana</option>\n\
<option name=\'NC\' value=\'NC\'>North Carolina</option>\n\
<option name=\'ND\' value=\'ND\'>North Dakota</option>\n\
<option name=\'NE\' value=\'NE\'>Nebraska</option>\n\
<option name=\'NH\' value=\'NH\'>New Hampshire</option>\n\
<option name=\'NJ\' value=\'NJ\'>New Jersey</option>\n\
<option name=\'NM\' value=\'NM\'>New Mexico</option>\n\
<option name=\'NV\' value=\'NV\'>Nevada</option>\n\
<option name=\'NY\' value=\'NY\'>New York</option>\n\
<option name=\'OH\' value=\'OH\'>Ohio</option>\n\
<option name=\'OK\' value=\'OK\'>Oklahoma</option>\n\
<option name=\'OR\' value=\'OR\'>Oregon</option>\n\
<option name=\'PA\' value=\'PA\'>Pennsylvania</option>\n\
<option name=\'PR\' value=\'PR\'>Puerto Rico</option>\n\
<option name=\'RI\' value=\'RI\'>Rhode Island</option>\n\
<option name=\'SC\' value=\'SC\'>South Carolina</option>\n\
<option name=\'SD\' value=\'SD\'>South Dakota</option>\n\
<option name=\'TN\' value=\'TN\'>Tennessee</option>\n\
<option name=\'TX\' value=\'TX\'>Texas</option>\n\
<option name=\'UT\' value=\'UT\'>Utah</option>\n\
<option name=\'VA\' value=\'VA\'>Virginia</option>\n\
<option name=\'VT\' value=\'VT\'>Vermont</option>\n\
<option name=\'WA\' value=\'WA\'>Washington</option>\n\
<option v=\'WI\' value=\'WI\'>Wisconsin</option>\n\
<option name=\'WV\' value=\'WV\'>West Virginia</option>\n\
<option name=\'WY\' value=\'WY\'>Wyoming</option>\n\
</optgroup>\n\
</select></td></tr>');
    }
    else
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');
    }
}
function employeeID(keye){
   str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
  st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text READONLY name=',keye,' value="',pdata[keye],'"/></td></tr>');
}

for (var key in pdata){
  switch(key)
      {
          case 'id': employeeID('id');
               break;

          case 'first_name': editableID('first_name');
               break;

          case 'last_name': editableID('last_name');
               break;

          case 'email': editable('email');
               break;

          case 'street': editable('street');
               break;

          case 'suite': editable('suite');
               break;

          case 'city': editable('city');
               break;

          case 'state': editable('state');
              break;

          case 'zipcode': editable('zipcode');
              break;

          case 'access_level': editableID('access_level');
              break;

          case 'last_access': nonEditableID('last_access');
              break;

      }
}


str.push('</table>');
st2.push('</table>');
html += str.join('');
formhtml += st2.join('');
st2 = [];

st2.push('<input type="submit" value="Update" name="action"/><input type="button" value="Cancel" id="cancel-edit"/></form>');
formhtml += st2.join('');
$('#profileBox').append( html );

$('#edit-profile-link').click( function(){
  if( $(this).html() == 'Edit' ){
    $(this).html('Cancel');
    $('#profileBox').html(formhtml);
    $('#cancel-edit').click( function(){$('#edit-profile-link').click();} );

  }
  else{
    $('#profileBox').html( html );
    $(this).html('Edit');
  }

  return false;
});

</script>

<?php get_footer(); ?>