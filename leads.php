<?php include('includes/_.php'); check_auth(); $_SESSION['view'] = 'Leads';  //only accessible to sales if ( $_SESSION['access_level'] != 3) {	die('<h1>Unauthorized</h1>'); } get_header();  ?><h1>Leads</h1><?php get_footer(); ?>