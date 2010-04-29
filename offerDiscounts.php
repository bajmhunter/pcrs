<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Offer Discounts';

 //only accessible to sales
if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
 }

$employeeID = $_SESSION['user_id'];
get_header();



function fetchOffer($offerID){

    global $db;
    $db->runQuery("select * from discounts where id=$offerID;");
        $rows = $db->result->fetch_assoc();
echo"<h1>Offer Details</h1>
            <div id=\"profileBox\">
            <table class=\"profile_sect\">
            <tr>
                <td class = 'field'>Offer ID</td>
                <td class = field'>$rows[id]</td>
            </tr>
            <tr>
                <td class = 'field'>Description</td>
                <td class = field'>$rows[description]</td>
            </tr>
            <tr>
            <tr>
                <td class = 'field'>Value [% Discount]</td>
                <td class = field'>$rows[value]</td>
            </tr>
            <tr>
                <td class = 'field'>Criteria [No. of Orders]</td>
                <td class = field'>$rows[criteria]</td>
            </tr>
            <tr>
                <td class = 'field'>Lead Type</td>
                <td class = field'>$rows[lead_type]</td>
            </tr>
                <td class = 'field'>Start Date</td>
                <td class = field'>$rows[start_date]</td>
            </tr>
            <tr>
                <td class = 'field'>End Date</td>
                <td class = field'>$rows[end_date]</td>
            </tr>
</table></div>

        ";
}
if(isset($_GET['offerID']) && (!isset($_POST['submit'])))
    {
        global $db;
        fetchOffer($_GET['offerID']);
        $offerID = $_GET['offerID'];
        displayResults($db,$offerID,'ongoing');
    }
if(isset($_GET['upcomingOfferID']) && (!isset($_POST['submit'])))
    {
        global $db;
        fetchOffer($_GET['upcomingOfferID']);
        $offerID = $_GET['upcomingOfferID'];
        displayResults($db,$offerID,'upcoming');
    }
if(isset($_GET['pastOfferID']) && (!isset($_POST['submit'])))
    {
        fetchOffer($_GET['pastOfferID']);
        echo "<h2> The offer has expired. It cannot be offered to any customer </h2>";
        //$offerID = $_GET['offerID'];
        //displayResults($db,$offerID,'past');
    }

function displayResults($db,$offerID,$message)
            {
$today = date("Y-m-d");
//global $activeCustomersArray;
$db->runQuery("select DISTINCT customer_id from customer_leads;");
$counter=0;
if($db->result->num_rows > 0)
        {
            while($customerRows = $db->result->fetch_assoc())
            {
                $activeCustomersArray[$counter++] = $customerRows['customer_id'];
            }
            for($i=0;$i<$counter;$i++)
            {
//                echo $i;
//              print_r($activeCustomersArray[$i]);
                $db->runQuery("select count(*) customer_id from customer_leads where customer_id = $activeCustomersArray[$i]");
                if($db->result->num_rows > 0)
                        {
                            while($criteriaRows = $db->result->fetch_assoc())
                            {
                                $thisCustomerLeads[$i]['customerID'] = $activeCustomersArray[$i];
                                $thisCustomerLeads[$i]['totalLeads'] = $criteriaRows['customer_id'];
                            }
                        }
            }
        }

$customerCounter = $counter;
$eligibleCustomersCounter=0;
$db->runQuery("select id,criteria from discounts where id = $offerID and start_date<='$today' and end_date>='$today'");
        $criteriaRow = $db->result->fetch_assoc();
        $criteria = $criteriaRow['criteria'];


             for($i=0;$i<$customerCounter;$i++)
                {
                    if($thisCustomerLeads[$i]['totalLeads'] >= $criteria)
                    {
                        //eligible;
                        $eligibleCustomers [$i] = $thisCustomerLeads[$i]['customerID'];
                        $eligibleCustomersCounter++;
                    }
                    else
                    {
                         //not eligible;
                        $notEligibleCustomers [$i]= $thisCustomerLeads[$i]['customerID'];
                    }
                }



if ($eligibleCustomersCounter >= 1)
    {
    switch ($message)
    {
        case ('ongoing'):
                echo "<h3> The following customers are eligible for this Discount Offer</h3>";
                    displayCustomer($db,$eligibleCustomersCounter,$eligibleCustomers,$thisCustomerLeads,'ongoing');
                        
                break;
        case('upcoming'):
                echo"<h3> The following customers will be* eligible for this Discount Offer</h3>";
        
                    displayCustomer($db,$eligibleCustomersCounter,$eligibleCustomers,$thisCustomerLeads,'upcoming');
        echo "*This discount cannot be offered now.";
                break;
    }
    }
    else
    {

        echo"<h3>There are no eligible customers for this offer yet.</h3>";
    }
}
function displayCustomer($db,$eligibleCustomersCounter,$eligibleCustomers,$thisCustomerLeads,$message)
        {
    echo
    "
        <form action='$PHP_SELF' method='POST'>
            <table id ='offersTable' class='profile_sect' align='center'>
                <tr align = 'center'>
                  <th class='field'>Custmomer ID</th>
                  <th class='field'>First Name</th>
                  <th class='field'>Last Name</th>
                  <th class='field'>Email</th>
                  <th class='field'>Type</th>
                  <th class='field'>Leads</th>
                </tr>
    ";

        for($i=0;$i<$eligibleCustomersCounter;$i++)
        {
            $db->runQuery("select C.id,C.first_name,C.last_name,C.email,C.type
                    from customers C where id = $eligibleCustomers[$i]");
            $rows = $db->result->fetch_assoc();
            $customerLeads = $thisCustomerLeads[$eligibleCustomers[$i]-1]['totalLeads'];
             echo
                "
                    <tr align='center'>
                        <td>$rows[id]</td>
                        <td>$rows[first_name]</td>
                        <td>$rows[last_name]</td>
                        <td>$rows[email]</td>
                        <td>$rows[type]</td>
                        <td>$customerLeads</td>
                     </tr>
                    <input type= 'hidden' value=$rows[id] name='rows$i'>

                ";
        }
if($message == "ongoing")
    {
        echo "Click to offer discount to all customers listed below<br/>";
        echo "</table>";
        echo
            "
                <form method='POST' action=$PHP_SELF>
                    <input type='hidden' value=$eligibleCustomersCounter name='eCC'>
                    <input type='hidden' value=$employeeID name='emp'>
                    <input type = 'submit' value='Offer Discount' name='submit'>
            ";
    }
else 
    echo "</table>";


}

if(isset($_POST['submit']))
    {
        //echo "Offer ID = ",
        
        $discountID = $_GET['offerID'];
        //echo "eCC Counter = ",

        $eligibleCustomersCounter = $_POST['eCC'];
        //echo $_POST['emp'];

        //echo "Employee ID =",
        $employeeID = $_SESSION['user_id'];

        for ($i=0;$i<$eligibleCustomersCounter;$i++)
            {
                $customerID = $_POST["rows$i"];
                $db->runQuery("insert into customer_discounts values ($discountID,$customerID,$employeeID,curdate());");
            }
    echo "<h1> Discount ID: $discountID has been offered to the following customers</h1>
    <form>
            <table id ='offersTable' class='profile_sect' align='center'>
                <tr align = 'center'>
                  <th class='field'>Custmomer ID</th>
                  <th class='field'>First Name</th>
                  <th class='field'>Last Name</th>
                  <th class='field'>Email</th>
                  <th class='field'>Type</th>
                </tr>";

for($i=0;$i<$eligibleCustomersCounter;$i++)
        {
            $customerID = $_POST["rows$i"];
            $db->runQuery("select C.id,C.first_name,C.last_name,C.email,C.type
                    from customers C where id = $customerID");
            $rows = $db->result->fetch_assoc();
            echo
                "
                    <tr align='center'>
                        <td>$rows[id]</td>
                        <td>$rows[first_name]</td>
                        <td>$rows[last_name]</td>
                        <td>$rows[email]</td>
                        <td>$rows[type]</td>
                     </tr>
                ";
        }
    }

echo "</table></body></html>";
get_footer();
?>