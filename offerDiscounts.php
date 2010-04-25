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


get_header();



echo"<h1>Offer Discounts </h1>";

get_footer();
?>