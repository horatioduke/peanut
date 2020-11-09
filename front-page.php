<?php /* 
This page is used to display the static frontpage. 
*/
 
// Fetch theme header template
get_header(); ?>

	<?php get_carousel_images(); ?>

	<?php get_portfolio_section(); ?>

	<?php get_about_section(); ?>

	<?php get_contact_section(); ?>

<?php get_footer(); ?>