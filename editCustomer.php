<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Edit Customer Information';

/*
* Only manager or Sales Person can update customer information
*/
 if ( $_SESSION['access_level'] < 3) {
	die('<h1>Unauthorized</h1>');
 }
get_header();

/*
 * Function to display results in a table format returned by the last query.
 */
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


if((!isset($_POST['submit1']))&& (!isset($_POST['submit2']))&& (!isset($_POST['leadID']))&& (!isset($_GET['error'])))
{

echo    "
            <!DOCTYPE HTML>
            <html>
                <body>
                    <form action= '$PHP_SELF' method='POST'>
                        <h1> Search Customer to Update Profile</h1><br/>
                        Search Criteria
                        <select id='sType' name='sType'>
                            <option value='lName'>Last Name</option>
                            <option value='fName'>First Name</option>
                            <option value='custID'>Customer ID</option>
                            <option value='eMail'>Customer e-Mail</option>
                            </select>
                        <input type='text' name='sCriteria'>
                        <input type='submit' value='Search' name='submit1'>
                    </form>
                </body>
            </html>";
    get_footer();

        }
if((isset($_POST['submit1'])) && (!isset($_POST['submit2'])) && (!isset($_GET['leadID']))&& (!isset($_GET['error'])))
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
                                var cust = document.getElementById('leadsTable').rows[indexOfRow].cells[0].innerHTML;
                                document.location.href = 'customerUpdate.php?custID='+cust;
                            }
                        </script>
                        </head>
                        <body>
                        <h3>Click to View / Update Customer Profile</h3>
                        <div id='profileBox'></div>
                        <form action='$PHP_SELF' method='POST'>
                            <table  align='center' id='leadsTable' class='profile_sect'>
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

                    $db->runQuery("select id ,first_name,last_name, email
                            from customers where last_name = $lName;");
                    if  ($db->result->num_rows > 0)
                        {
                            displayResults($db);

                            $customerFound=1;
                        }
                    else
                        {
                            echo"<script>location.href='editCustomer.php?error=1'</script>";
                        }
                    break;

                    case "fName" :
                        $fName = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select id ,first_name,last_name, email
                            from customers where first_name = $fName;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);

                                $customerFound=1;
                            }
                        else
                            {
                               echo"<script>location.href='editCustomer.php?error=1'</script>";
                            }
                        break;

                    case "custID" :

                        $custID = $_POST['sCriteria'];
                        $db->runQuery("select id ,first_name,last_name, email
                            from customers where id = $custID;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                echo"<script>location.href='editCustomer.php?error=1'</script>";
                            }
                        break;

                    case "eMail" :
                        $eMail = "'".$_POST['sCriteria']."'";

                        $db->runQuery("select id ,first_name,last_name, email
                            from customers where email = $eMail;");
                        if  ($db->result->num_rows > 0)
                            {
                                displayResults($db);
                                $customerFound=1;
                            }
                        else
                            {
                                echo"<script>location.href='editCustomer.php?error=1'</script>";
                            }
                        break;


                }
                echo"</table></form></body></html>";
                get_footer();
    }
if (isset($_GET['error']))
    {
        echo "<h3>ERROR: Not found!</h3>";
        echo '<br/><br/><form><input type="submit" value="Try Again" onClick="history.go(-1);return true;"> </form>';
    }
?>
