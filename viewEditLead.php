<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Leads';

 //only accessible to sales
 if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
 }
get_header();

 function displayResults($db)
 {
            
             $counter=0;
            while($rows = $db->result->fetch_assoc())
            {

                $counter+=1;
                echo"
                        <tr align = 'center' id = '$counter' onmouseover = 'changeRowColor(this,true);' onmouseout = 'changeRowColor(this,false);'
                onclick='pageRedirect($counter);'>
                            
                            <td>$rows[lead_id]</td>
                            <td>$rows[customer_id]</td>
                            <td>$rows[first_name]</td>
                            <td>$rows[last_name]</td>
                            <td>&nbsp $rows[email] &nbsp</td>
                            <td>$rows[employee_id]</td>
                            <td>&nbsp $rows[date] &nbsp</td>
                            <td>$rows[type]</td>
                        </tr>
                    ";

            }


 }

 function errorNotFound()
 {
    echo "<h5>ERROR: NOT found!</h5>";
    echo '<br/><br/><form><input type="submit" value="Try Again" onClick="history.go(-1);return true;"> </form>';
 }


if((!isset($_POST['submit1']))&& (!isset($_POST['submit2']))&& (!isset($_POST['leadID'])))
{

echo    "
            <!DOCTYPE HTML>
            <html>
                <body>
                    <form action= '$PHP_SELF' method='POST'>
                        <h1> Search Lead(s) to View / Update</h1><br/>
                        Search Criteria
                        <select id='sType' name='sType'>
                            <option value='lName'>Last Name</option>
                            <option value='fName'>First Name</option>
                            <option value='custID'> Customer ID</option>
                            <option value='leadID'> Lead ID </option>
                            <option value='empID'> Sales Person's ID </option>
                            <option value='leadType'> Lead Type </option>
                            <option value='date'> Date </option>
                            <option value='eMail'>Customer e-Mail</option>
                        </select>
                        <input type='text' name='sCriteria'>
                        <input type='submit' value='Search' name='submit1'>
                    </form>
                </body>
            </html>";
    get_footer();
        
        }
if((isset($_POST['submit1'])) && (!isset($_POST['submit2'])) && (!isset($_GET['leadID'])))
    {
     echo
                "
                    <html>
                        <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
                        <script type='text/javascript'>
                            function changeRowColor (Row,State)
                            {
                                if(State)
                                    {
                                        Row.style.backgroundColor = '#E0E0E0';
                                        Row.style.color = 'Black';
                                    }
                                else
                                    {
                                        Row.style.backgroundColor = '#f6f6f6';
                                        Row.style.color = 'Black';
                                    }
                            }

                            function pageRedirect(indexOfRow)
                            {
                                var lead = document.getElementById('leadsTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'leadUpdate.php?leadID='+lead;
                            }
                        </script>
                        </head>
                        <body>
                        <h3>Click to View / Update Lead</h3>
                        <div id='profileBox'></div>
                        <form action='$PHP_SELF' method='POST'>
                            <table  align='center' id='leadsTable' class='profile_sect'>
                                <tr align = 'center'>
                                    <th> &nbsp &nbsp Lead ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Customer ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp First Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Last Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp e-Mail ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Sales Person's ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Date &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Lead Type &nbsp &nbsp </th>
                                </tr>
                ";
            switch($_POST['sType'])
            {

                case "lName" :
                    $lName = "'".$_POST['sCriteria']."'";
                
                    $db->runQuery("select CL.lead_id , CL.customer_id ,
                            first_name, last_name ,email, CL.employee_id , date, L.type
                            from customer_leads CL, customers C, Leads L where
                            C.last_name=$lName and C.id = CL.customer_id and L.id = CL.lead_id;");
                    if  ($db->result->num_rows > 0)
                        {
                            displayResults($db);

                            $customerFound=1;
                        }
                    else
                        {
                            errorNotFound();
                        }
                    break;
                    
                    case "fName" :
                        $fName = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                C.first_name=$fName and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);

                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;
                    
                    case "custID" :
 
                        $custID = $_POST['sCriteria'];
                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                C.id=$custID and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;
                    
                    case "leadID" :
                        
                        $leadID = $_POST['sCriteria'];
                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                CL.lead_id=$leadID and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;

                    case "empID" :

                        $employeeID = $_POST['sCriteria'];
                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                CL.employee_id=$employeeID and C.id = CL.customer_id and L.id = CL.lead_id;");
          
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;
                    
                    case "eMail" :
                        $eMail = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                C.email=$eMail and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;
                    
                    case "leadType" :
                        $leadType = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                L.type=$leadType and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;

                    case "date" :
                        $date = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select CL.lead_id , CL.customer_id ,
                                first_name, last_name ,email, CL.employee_id , date, L.type
                                from customer_leads CL, customers C, Leads L where
                                CL.date=$date and C.id = CL.customer_id and L.id = CL.lead_id;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                errorNotFound();
                            }
                        break;

                }
                echo"</table></form></body></html>";
                get_footer();
    }

?>
