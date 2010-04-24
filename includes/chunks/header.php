<?php
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
                    <li><a href="orders.php">Orders</a></li>

                    <?php if( $_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 4 ) : ?>
                    <li><a href="complaints.php"><span class="notice">17</span>Complaints</a></li>
                    <?php endif; ?>

                    <li><a href="discounts.php">Discounts</a></li>

                    <?php if( $_SESSION['access_level'] == 3 ) : ?>
                     <li><a href="#" onmouseover="menuOpen('leads')" onmouseout="menuCloseTimer()">Leads</a>
                           <div id="leads" onmouseover="menuCancelCloseTimer()" onmouseout="menuCloseTimer()">
                               <a href ="createLead.php">Create Lead</a>
                               <a href ="viewEditLead.php">View / Edit Leads</a>
                               <a href ="reportLead.php"> Report Lead Status</a>
                           </div>
                    </li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] > 1 ) : ?>
                    <li><a href="customers.php">Customers</a></li>
                    <?php endif; ?>

                    <?php if( $_SESSION['access_level'] == 4 ) : ?>
                    <li><a href="employees.php">Employees</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <div id="container">