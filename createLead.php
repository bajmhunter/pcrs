<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Leads';

 //only accessible to sales
 if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
 }

get_header();

//employee ID
$empID = $_SESSION['user_id'];
$record;


/*function singleResult($db)
 {
    
    $record = $db->result->fetch_object();
    echo"<form action ='$PHP_SELF' method='POST'>";
    echo "<h5>Enter Lead Details for $record->first_name $record->last_name</h5>";

    $db->runQuery("select id from customers where last_name = '$record->last_name' and first_name = '$record->first_name';");
    $record = $db->result->fetch_object();
    $custID = $record->id;
    echo "<input type ='hidden' name ='Customer' value=$custID";
  
 }
*/
 function displayResults($db)
 {
            /*echo"<form action ='$PHP_SELF' method='POST'>";
            echo "Select Customer <select id='Customer' name='Customer'>";
            while($rows = $db->result->fetch_assoc())
            {
                echo"<option value='$rows[id]'>$rows[first_name] $rows[last_name]</option>";
            }
         echo "</select>";*/
         
             $counter=0;
            while($rows = $db->result->fetch_assoc())
            {

                $counter+=1;
                echo"
                        <tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                onclick='pageRedirect($counter);'>
                            <td>$rows[id]</td>
                            <td>$rows[first_name]</td>
                            <td>$rows[last_name]</td>
                            <td>&nbsp $rows[email] &nbsp</td>
                        </tr>
                    ";

            }
            


 }

 
 function errorNotFound()
 {
    echo "ERROR: Customer NOT found.";
    echo '<br/><br/><form><input type="submit" value="Try Again" onClick="history.go(-1);return true;"> </form>';
 }



if ((!isset($_POST['submit1'])) && (!isset($_GET['submit2'])) && (!isset($_GET['customerID'])))
    {


echo    "
            <!DOCTYPE HTML>
            <html>
                <body>
                    <form action= '$PHP_SELF' method='POST'>
                        <h1>Search Customer to create Lead</h1><br/>
                            Search Criteria <select id='sType' name='sType'>
                            <option value='lName'>Last Name</option>
                            <option value='fName'>First Name</option>
                            <option value='iD'>Customer ID</option>
                            <option value='eMail'>e-Mail</option>
                        </select>
                        <input type='text' name='sCriteria'>
                        <input type='submit' value='Search' name='submit1'>
                    </form>";
                    get_footer();
    echo"
                </body>
            </html>
        ";
}
if((isset($_POST['submit1'])) && (!isset($_GET['submit2'])))
    {
        echo"
                <html>
                        <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
                        <script type='text/javascript'>
                            function changeRowColor (Row,State)
                            {
                                if(State)
                                    {
                                        Row.style.backgroundColor = 'Black';
                                        Row.style.color = 'white';
                                    }
                                else
                                    {
                                        Row.style.backgroundColor = 'white';
                                        Row.style.color = 'Black';
                                    }
                            }

                            function pageRedirect(indexOfRow)
                            {
                                var customer = document.getElementById('leadsTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'createLead.php?customerID='+customer;
                            }
                        </script>
                        </head>
                        <body>
                        <h2>Select Customer to create Lead</h2>
                        <form action='$PHP_SELF' method='POST'>
                            <table  align='center' id='leadsTable'>
                                <tr align = 'center'>
                                    <th> &nbsp &nbsp Customer ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp First Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Last Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp e-Mail ID &nbsp &nbsp </th>
                                </tr>
                ";
        switch($_POST['sType'])
            {
                case "lName" : 
                    $lName = "'".$_POST['sCriteria']."'";
                    $db->runQuery("select first_name,last_name,id,email from customers where last_name=$lName");
                    if($db->result->num_rows >= 1)
                        {
                            displayResults($db);
                        }
                    else
                        {
                            errorNotFound();
                        }
                    break;

                case "fName" : 
                    $fName = "'".$_POST['sCriteria']."'";
                    $db->runQuery("select first_name,last_name,id,email from customers where first_name=$fName");
                    if($db->result->num_rows >= 1)
                        {
                            displayResults($db);
                        }
                    else
                        {
                            errorNotFound();
                        }
                    break;

                case "iD"    :
                    $iD = "'".$_POST['sCriteria']."'";
                    $db->runQuery("select first_name,last_name,id,email from customers where iD=$iD");
                    if($db->result->num_rows >= 1)
                        {
                            displayResults($db);
                        }
                    else
                        {
                            errorNotFound();
                        }
                    break;

                case "eMail" :
                    $eMail = "'".$_POST['sCriteria']."'";
                    $db->runQuery("select first_name,last_name,id,email from customers where email=$eMail");
                    if($db->result->num_rows >= 1)
                        {
                            displayResults($db);
                        }
                    else
                        {
                            errorNotFound();
                        }
                    break;

                default:
                    echo "Default Error!";
                break;
            }
        echo"</table></form>";
        echo"</body></html>";
        get_footer();
            //$dbnum_rows = $db->result->num_rows;
    }

if(isset($_GET['customerID']))
    {


    $customerID = $_GET['customerID'];
    $db->runQuery("select first_name,last_name,id from customers where id = $customerID");
    $record = $db->result->fetch_object();
    echo "
                <Html>
                    <head>
                        <script type='text/javascript'>
                            function submitQuery()
                            {
                                document.location.href = 'createLead.php?';
                            }
                        </script>
                    </head>
                    <Body>
                        <form method='GET' action='$PHP_SELF'>
                        <h5> Enter Lead Details for $record->first_name $record->last_name (CustomerID: $record->id)</h5>

                            <table cellspacing ='0' cellpadding='0'>
                                <tr>
                                    <td>Lead Type &nbsp
                                        <select id ='ltype' name='ltype'>
                                            <option value='Sales'>Sales</option>
                                            <option value='Repair'>Repair</option>
                                            <option value='Installation'>Installation</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>Lead Desciption
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        <textarea name='txt'></textarea>
                                    </td>
                                </tr>
                            </table>
                           
                            <!-- <input type='hidden' name='numrows' value=$dbnum_rows> -->
                            <input type='hidden' name='custID' value='$record->id'>
                            <input type='submit' value='Create Lead' name='submit2' onclick = submitQuery($record->id,ltype,desc)>
                        </form>";
            get_footer();
                  echo"</Body>
            </Html>
            ";

    }

if(isset($_GET['submit2']))
    {
        //echo "here = ";
        $custID = $_GET['custID'];
        //echo $custID;
        $lType = "'".$_GET['ltype']."'";
        $desc = "'".$_GET['txt']."'";
        //echo $custID,$lType,$desc;
        $db->runQuery("insert into leads values (null,$desc,$lType,'Open');");
        $lastLeadID = $db->getLastInsertID();


/*          Dunno why this seems to malfunction at times! will have a look later!
*
*          $db->runQuery("select id from leads where last_insert_id() = $lastID");
*          $rec = $db->result->fetch_object();
*          $leadID = $rec->id;
*          echo " leadID = ";echo $leadID;
*/
        $db->runQuery("insert into customer_leads values(null,$empID,$custID,$lastLeadID,1,null);");
        $lastID = $db->getLastInsertID();
        $db->runQuery("select first_name, last_name from customers C, customer_leads CL where CL.id = $lastID and CL.customer_id = C.id");
        $record = $db->result->fetch_object();

        $db->runQuery(" select CL.lead_id as 'Lead ID', CL.customer_id as 'Customer ID',C.first_name as 'Customer First Name',
                        C.last_name as 'Customer Last Name',
                        C.email as 'Customer Email',CL.date as 'Creation Date',CL.rank as Rank, L.description as Description,L.type as Type,L.status as Status
                        from
                        customers C,customer_leads CL,leads L
                        where CL.lead_id = $lastLeadID
                        and CL.lead_id = L.id
                        and C.id = CL.customer_id;
                     ");

                    $_SESSION['msg'] = '<div class="message">Lead Created!</div>';
                    $columns = $db->result->field_count;

        echo "
                    <!--<body onload='displayLead()'>-->
                        <div id='profileBox'></div>
                        <h3>Lead Created!</h3>
                        
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
       echo"</table></body></html>";
       get_footer();
       unset($_SESSION['msg']);
    }

?>


