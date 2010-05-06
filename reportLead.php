<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'Leads';

 //only accessible to salesperson
 if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
 }

get_header();
?>
<html>
    <body>
        <h1> Report Lead Status</h1>
        <h3> Future Enhancement</h3>
    </body>
</html>

<?php get_footer(); ?>