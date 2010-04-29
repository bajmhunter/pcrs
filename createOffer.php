<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Create Offers';

 //only accessible to sales
  if ( $_SESSION['access_level'] != 4) {
	die('<h1>Unauthorized</h1>');
 }


get_header();

 if(isset($_POST['submit']))
        {
           $desc = "'".$_POST['desc']."'" ;
           $sdate = "'".$_POST['sDate']."'" ;
           $edate = "'".$_POST['eDate']."'" ;
           //$eid = $_POST['eId'] ;
           $value = $_POST['value'] ;
           $criteria = "'".$_POST['criteria']."'" ;
           $leadtype = "'".$_POST['lType']."'";
           //echo $criteria;
            $db->runQuery("insert into discounts values (null,$desc,$sdate,$edate,2,$value,$leadtype,$criteria);");
            if($db->result)
            {
                $_SESSION['msg'] = '<div class="message">Offer Created!</div>';
                $offerID = $db->getLastInsertID();
                //echo "last insert id = $offerID";
            }

            else
            {
                    $_SESSION['msg'] = '<div class="message error">Offer Creation Failed!</div>';
            }
        
        //echo "last insert id = $offerID <hr/>";
        $db->runQuery("select * from discounts where id = $offerID");
        $rows = $db->result->fetch_object();
        $pdata = json_encode($rows);
       // print_r($pdata);
     $db->runQuery(" select id as 'Offer ID', description as Description, value as Value,lead_type as 'Lead Type',
              criteria as Criteria,start_date as 'Start Date', end_date as 'End Date', employee_id as 'Employee ID'
             from discounts where id = $offerID ");

                    $_SESSION['msg'] = '<div class="message">Offer Created!</div>';
                    $columns = $db->result->field_count;

        echo "
                <h1> Offer Created! </h1>
                <div id='profileBox'></div>
                <ul class='search-criteria-list'>
                    <li><a>Details</a>
                        <table class='profile_sect'>
             ";

       $i=0;
       $rows = $db->result->fetch_assoc();
       while($columns>0)
       {
           //echo $columns;
           $fieldHeader = $db->result->fetch_field_direct($i);
           $fieldName = $fieldHeader->name;
           //echo $fieldName;
           //$fieldOrgName = $fieldHeader->orgname;
           //echo $fieldOrgName;
           echo
           "<tr>
               <td class='field'>$fieldName</td> <td>$rows[$fieldName]</td>
            </tr>";
            $columns--;
            $i++;
       }
       echo"</li></ul></table></div></body></html>";
       get_footer();
       unset($_SESSION['msg']);
        }

    else{
            echo"<html>

    <head>
    <link rel='stylesheet' href='assets/css/master.css' />

    </head>
    <body>

<h1> Create New Offer </h1>
<div id='customer-search-wrap'>
<form id='find-customer' method='POST' action=$PHP_SELF>
    <ul class='search-criteria-list'>
        <li><a>Offer Details</a>

<table id='#details' class='table2'>
                <tr>
                    <td>Offer Description</td><td><input type='text' class='full' name='desc'/></td>
                </tr>
                <tr><td><br/></td></tr>
                <tr>
                    <td>Lead Type</td><td> <select name='lType'><option value='Sales'>Sales</option><option value='Repair'>
                                Repair</option><option value='Installation'>Installation</option></td>
                </tr>
                <tr><td><br/></td></tr>
                <tr>
                    <td>Criteria</td><td><input type='text' class='mid' name='criteria'/>&nbsp &nbsp[No of Leads]</td>
                </tr>
               <tr><td><br/></td></tr>
                <tr>
                    <td>Discount Value</td><td><input type='text' name='value'/>&nbsp &nbsp[Expressed as %]</td>
                </tr>
                        <tr><td><br/></td></tr>
                <tr>
                    <td>Start Date</td><td><input name='sDate' id='sDate' type='textbox' name='sdate'/></td>
                </tr>
                <tr><td><br/></td></tr>
                <tr>
                    <td>End Date</td><td><input name='eDate' id ='eDate' type='textbox' name='edate'/></td>
                </tr>

            </table>
        </li>
    </ul>

    &nbsp; &nbsp; <input type='submit' value='Create' name='submit'>
    </form>
</div>


        <script type='text/javascript' src='assets/js/jquery.js'></script>
        <script type='text/javascript' src='assets/js/jquery.ui.js'></script>
        <script type='text/javascript'>

            $(document).ready(function(){
           $('#sDate').datepicker({ showOn: 'button', buttonImageOnly: true, buttonImage: 'assets/images/datePicker.gif',dateFormat: 'yy-mm-dd'});
            });
            $(document).ready(function(){
           $('#eDate').datepicker({ showOn: 'button', buttonImageOnly: true, buttonImage: 'assets/images/datePicker.gif', dateFormat: 'yy-mm-dd'});
            });
        </script>

</body>
</html>";
}
get_footer();
?>
