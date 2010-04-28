<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Edit Employee Information';

 //only accessible to sales
 if ( $_SESSION['access_level'] != 4) {
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
                        <h1> Search Employee to Update Profile</h1><br/>
                        Search Criteria
                        <select id='sType' name='sType'>
                            <option value='lName'>Last Name</option>
                            <option value='fName'>First Name</option>
                            <option value='empID'>Employee ID</option>
                            <option value='eMail'>Employee e-Mail</option>
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
                                var emp = document.getElementById('leadsTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'employeeUpdate.php?empID='+emp;
                            }
                        </script>
                        </head>
                        <body>
                        <h3>Click to View / Update Employee Profile</h3>
                        <div id='profileBox'></div>
                        <form action='$PHP_SELF' method='POST'>
                            <table  align='center' id='leadsTable' class='profile_sect'>
                                <tr align = 'center'>
                                    <th> &nbsp &nbsp Employee ID &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp First Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp Last Name &nbsp &nbsp </th>
                                    <th> &nbsp &nbsp e-Mail ID &nbsp &nbsp </th>
                                </tr>
                ";
            switch($_POST['sType'])
            {

                case "lName" :
                    $lName = "'".$_POST['sCriteria']."'";

                    $db->runQuery("select id ,first_name,last_name, email
                            from employees where last_name = $lName;");
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

                        $db->runQuery("select id ,first_name,last_name, email
                            from employees where first_name = $fName;");
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

                        $empID = $_POST['sCriteria'];
                        $db->runQuery("select id ,first_name,last_name, email
                            from employees where id = $empID;");
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

                        $db->runQuery("select id ,first_name,last_name, email
                            from employees where email = $eMail;");
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
