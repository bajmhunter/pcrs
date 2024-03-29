<?php

include_once('includes/db.php');
global $db;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
        <link rel="shortcut icon" href="favicon.png" />
        <link rel="stylesheet" href="assets/css/master.css" />
        <title><?php echo $_SESSION['view'] ?></title>
        <!--
        <script src="http://www.google.com/jsapi"></script>
        -->
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <script type="text/javascript" src="assets/js/jquery.ui.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
        <script type="text/javascript" src="assets/js/cascadingMenu.js"></script>
    </head>
    <body id="body">
        <div id="top">
            <div id="session_info">
            <?php echo $_SESSION['full_name'] ?> | <a href="profile.php">Profile</a> | <a href="auth.php?logout=1">Sign out</a>
            </div>
            <div id="nav">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <?php if( $_SESSION['access_level'] == 1 ) : ?>
                     <li>
                        <a href="#" onmouseover="menuOpen('orders')" onmouseout="menuCloseTimer()">My Orders</a>
                           <div id="orders" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="myOrders.php?status=Open">Open Orders</a>
                               <a href ="myOrders.php?status=Closed">Past Orders</a>
                           </div>
                    </li>
                    <?php endif;?>

                    <?php if( $_SESSION['access_level'] == 1) : ?>
                    <li><a href="complaints.php">
                                <?php

                            $customerID = $_SESSION['user_id'];
    $db->runQuery("select count(*) as count from customer_complaints where status='1' and customer_id=$customerID;");
    $rows = $db->result->fetch_assoc();
    if($rows['count'] > 0 ) echo '<span class="notice">'.$rows['count'].'</span>';
?>
                      Complaints</a></li>
                          <?php endif; ?>
<?php if( $_SESSION['access_level'] == 4) : ?>
                    <li><a href="complaints.php">
                                <?php

                            $customerID = $_SESSION['user_id'];
    $db->runQuery("select count(*) as count from customer_complaints where status='1';");
    $rows = $db->result->fetch_assoc();
    if($rows['count'] > 0 ) echo '<span class="notice">'.$rows['count'].'</span>';
?>
                            Complaints</a></li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 1 ) : ?>
                    <li>
                        <a href="#" onmouseover="menuOpen('offers')" onmouseout="menuCloseTimer()">Discounts</a>
                           <div id="offers" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="myOffers.php">My Offers</a>
                               <a href ="viewOffers.php">View All Offers</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 3 ) : ?>
                    <li>
                        <a href="#" onmouseover="menuOpen('offers')" onmouseout="menuCloseTimer()">Discounts</a>
                           <div id="offers" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="viewOffers.php">View Offers</a>
                               <a href ="viewOffers.php?offerDiscounts=1">Offer Discounts</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 4 ) : ?>
                    <li>
                        <a href="#" onmouseover="menuOpen('offers')" onmouseout="menuCloseTimer()">Discounts</a>
                           <div id="offers" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="viewOffers.php">View Offers</a>
                               <a href ="createOffer.php">Create Offers</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 3 ) : ?>
                     <li><a href="#" onmouseover="menuOpen('leads')" onmouseout="menuCloseTimer()">Leads</a>
                           <div id="leads" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="createLead.php">Create Lead</a>
                               <a href ="viewEditLead.php">View / Edit Leads</a>
                               <a href ="reportLead.php"> Report Lead Status</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 4 ) : ?>
                     <li><a href="#" onmouseover="menuOpen('leads')" onmouseout="menuCloseTimer()">Leads</a>
                           <div id="leads" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="viewEditLead.php?status=Open&user=manager">View Open Leads</a>
                               <a href ="viewEditLead.php?status=Closed&user=manager">View Closed Leads</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] > 1 ) : ?>
                    <li><a href="#" onmouseover="menuOpen('customers')" onmouseout="menuCloseTimer()">Customers</a>
                           <div id="customers" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="addCustomer.php">Add Customer</a>
                               <a href ="searchCustomers.php">Search Customer(s)</a>
                               <a href ="editCustomer.php">Edit Customer Information</a>
                           </div>
                    </li>

                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 4 ) : ?>
                     <li><a href="#" onmouseover="menuOpen('employees')" onmouseout="menuCloseTimer()">Employees</a>
                           <div id="employees" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="addEmployee.php">Add Employee</a>
                               <a href ="searchEmployees.php">Search Employee(s)</a>
                               <a href ="editEmployee.php">Edit Employee Information</a>
                           </div>
                    </li>

                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div id="container">
