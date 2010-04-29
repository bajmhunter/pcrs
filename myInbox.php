<?php
 include('includes/_.php');
 check_auth();
 $_SESSION['view'] = 'My Inbox';

 //only accessible to sales
 /*if ( $_SESSION['access_level'] != 3) {
	die('<h1>Unauthorized</h1>');
 }*/
 get_header();?>

<h1> My Inbox </h1>
<h3> Future Enhancement </h3>
<?php get_footer(); ?>