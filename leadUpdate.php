<?php
 include('includes/_.php');
 check_auth();

    if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
        }

        get_header();

        $leadID = $_GET['leadID'];
        $empID = $_SESSION['user_id'];

        if( $_GET['action'] == 'Update' )
        {
            $status = $_GET['status'];
            $desc = $_GET['description'];
            $leadiD = $_GET['lead_id'];
            $rank = $_GET['rank'];
            $db->runQuery("update leads,customer_leads set status='$status', description='$desc', rank=$rank
                    where leads.id = $leadiD and customer_leads.id = leads.id;");
            if($db->result)
            {
                $_SESSION['msg'] = '<div class="message">Lead Updated!</div>';
                $leadID = $leadiD;
            }

            else
            {
                    $_SESSION['msg'] = '<div class="message error">Lead Update Failed!</div>';
            }
        }


        $db->runQuery(" select CL.lead_id as lead_id, C.first_name as customer_first_name, C.last_name as customer_last_name,
                        C.email as customer_email, E.first_name as employee_first_name, E.last_name as employee_last_name, E.email as employee_email,
                        CL.date,CL.rank,L.description,L.status,L.type,CL.customer_id, CL.employee_id
                        from
                        customers C, employees E,customer_leads CL,leads L
                        where CL.lead_id = $leadID
                        and CL.lead_id = L.id
                        and C.id = CL.customer_id
                        and E.id = CL.employee_id;
                      ");
        $rows = $db->result->fetch_object();
        $pdata = json_encode($rows);

        //print_r($pdata);
        


 ?>

        <h1 id="profile-h1"> <a href="#" id="edit-profile-link">Edit</a></h1>
        <div id="profileBox"></div>
       
<script type="text/javascript">

showMsg('<?php get_msg(); ?>');

var pdata = <?php echo $pdata; ?>;

var html = '';
var formhtml = '';

$('#profile-h1').prepend('Lead ID: ',pdata['lead_id']);

var str= ['<h3>Lead Information</h3><table class="profile_sect">'];
var st2= ['<h3>Edit Lead Information</h3><form><table class="profile_sect">'];

function nonEditable(keye){
    str.push('<tr><td class="field">',keye.capitalize(),'</td><td>',pdata[keye],'</td></tr>');
    st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text disabled="disabled" name=',keye,' value="',pdata[keye],'"/></td></tr>');

}
function nonEditableID(keye){
  str.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
  st2.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td><td><input type=text disabled = "disabled" name=',keye,' value="',pdata[keye],'"/></td></tr>');
}

function editable(keye){
    if(keye=='status')
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><select name=',keye,'><option>Open</option><option>Closed</option></td></tr>');
    }
    else if(keye=='rank')
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><select name=',keye,'><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></td></tr>');
    }
    else
    {
        str.push('<tr><td class="field">',keye.capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
        st2.push('<tr><td class="field">',keye.capitalize(),'</td><td><input type=text name=',keye,' value="',pdata[keye],'"/></td></tr>');
    }
}
function forLeadID(keye){
   str.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td> <td>',pdata[keye],'</td></tr>');
  st2.push('<tr><td class="field">',keye.replace('_',' ').capitalize(),'</td><td><input type=text READONLY name=',keye,' value="',pdata[keye],'"/></td></tr>');
}

for (var key in pdata){
  switch(key)
      {
          case 'lead_id': forLeadID('lead_id');
               break;
          
          case 'customer_first_name': nonEditableID('customer_first_name');
               break;

          case 'customer_last_name': nonEditableID('customer_last_name');
               break;
               
          case 'customer_email': nonEditableID('customer_email');
               break;
               
          case 'employee_first_name': nonEditableID('employee_first_name');
               break;
               
          case 'employee_last_name': nonEditableID('employee_last_name');
               break;
               
          case 'employee_email': nonEditableID('employee_email');
               break;               
               
          case 'customer_id': nonEditableID('customer_id');
              break;
          
          case 'employee_id': nonEditableID('employee_id');
              break;

          case 'rank': editable('rank');
              break;

          case 'date': nonEditable('date');
              break;

          case 'type': nonEditable('type');
              break;

          case 'status': editable('status');
              break;

          case 'description': editable('description');
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