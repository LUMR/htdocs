<?php 
require_once('fns_book_sc.php');
session_start();

do_html_header('ADD USER');

if (check_filled($_POST)) {
	
	$mes = save_userdate($_POST);
	echo $mes;
	display_button('add_user_form.php','','BACK');
}
else{
	echo "<p>You haven't input all .</p>";
	display_button('add_user_form.php','','BACK');
	do_html_footer();
	exit;
}


?>