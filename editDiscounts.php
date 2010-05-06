<?php

include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Edit Offer';

/*
* Only Manager Can edit discounts
*/
  if ( $_SESSION['access_level'] != 4) {
	die('<h1>Unauthorized</h1>');
 }


get_header();

        $offerID = $_GET['offerID'];
    /*
     * If the User has clicked on Submit Button, prepare query and create new customer with the
     * posted information.
     */
        if( $_GET['action'] == 'Update' )
        {
            $offeriD = $_GET['id'];
            $value = $_GET['value'];
            $startDate = "'".$_GET['start_date']."'";
            $endDate = "'".$_GET['end_date']."'";
            $leadType = "'".$_GET['lead_type']."'";
            $criteria = "'".$_GET['criteria']."'";
            $description = "'".$_GET['description']."'";

            $db->runQuery("update discounts set
                    description = $description, start_date = $startDate, end_date = $endDate,
                    lead_type = $leadType, criteria = $criteria, value = $value
                    where id = $offeriD;");
            if($db->result)
            {
                $_SESSION['msg'] = '<div class="message">Offer Updated!</div>';
                $offerID = $offeriD;
            }

            else
            {
                    $_SESSION['msg'] = '<div class="message error">Offer Update Failed!</div>';
            }
        }


        $db->runQuery(" select * from discounts where id=$offerID");
        $rows = $db->result->fetch_object();
        $pdata = json_encode($rows);





 ?>
        <h1 id="profile-h1"> <a href="#" id="edit-profile-link">Edit</a></h1>
        <div id="profileBox"></div>
<!--
JavaScript to toggle display between Edit and Cancel Views to update the Discount Information.
-->
<script type='text/javascript' src='assets/js/jquery.js'></script>
<script type='text/javascript' src='assets/js/jquery.ui.js'></script>

<script type="text/javascript">

showMsg('<?php get_msg(); ?>');

var pdata = <?php echo $pdata; ?>;

var html = '';
var formhtml = '';

$('#profile-h1').prepend('Offer ID: ',pdata['id']);

var str= ['<h3>Offer Information</h3><table class="profile_sect">'];
var st2= ['<h3>Edit Offer Information</h3><form><table class="profile_sect">'];

function nonEditableID(keye){
    str.push('<tr><td class="field">',keye.replace('_','').capitalize(),'</td><td>',pdata[keye],'</td></tr>');
    st2.push('<tr><td class="field">',keye.replace('_','').capitalize(),'</td><td><input type=text disabled="disabled" name=',keye,' value="',pdata[keye],'"/></td></tr>');

}

function editableID(keye){
    str.push('<tr><td class="field">',keye.replace('_','').capitalize(),'</td><td>',pdata[keye],'</td></tr>');
    st2.push('<tr><td class="field">',keye.replace('_','').capitalize(),'</td><td><select name=',keye,'><option>Sales</option><option>Repair</option><option>Installation</option></td></tr>');

}

function editable(keye){
    if(keye=='criteria'){
    str.push('<tr><td class="field">',keye.capitalize(),'&nbsp[No. of Sales]</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'&nbsp[No. of Sales]</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');

    }
    else if(keye=='value'){
    str.push('<tr><td class="field">',keye.capitalize(),'&nbsp[% Discount]</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'&nbsp[% Discount]</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');

    }
else{        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');
    }
}
function editableDate(keye){
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text id=',keye,' value="',pdata[keye],'"/></td></tr>');

}

function forID(keye){
   str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
  st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text READONLY name=',keye,' value="',pdata[keye],'"/></td></tr>');
}

for (var key in pdata){
  switch(key)
      {
          case 'id': forID('id');
               break;

          case 'description': editable('description');
               break;

          case 'value': editable('value');
               break;

          case 'start_date': editableDate('start_date');
               break;

          case 'end_date': editableDate('end_date');
               break;

          case 'lead_type': editableID('lead_type');
               break;

          case 'criteria': editable('criteria');
              break;

          case 'employee_id': nonEditableID('employee_id');
               break;

      }
}


str.push('</table>');
st2.push('</table>');
html += str.join('');
formhtml += st2.join('');
st2 = [];

st2.push('<input type="submit" value="Update" name="action"/>&nbsp<input type="button" value="Cancel" id="cancel-edit"/></form>');
formhtml += st2.join('');
$('#profileBox').append( html );

$('#edit-profile-link').click( function(){
  if( $(this).html() == 'Edit' )
  {
    $(this).html('Cancel');
    $('#profileBox').html(formhtml);
    $('#cancel-edit').click( function(){$('#edit-profile-link').click();} );
    $('#start_date').datepicker({ showOn: 'button', buttonImageOnly: true, buttonImage: 'assets/images/datePicker.gif',dateFormat: 'yy-mm-dd'});
    $('#end_date').datepicker({ showOn: 'button', buttonImageOnly: true, buttonImage: 'assets/images/datePicker.gif', dateFormat: 'yy-mm-dd'});
  }
  else{
    $('#profileBox').html( html );
    $(this).html('Edit');
  }

  return false;
});


</script>

<?php get_footer(); ?>