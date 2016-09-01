<?php 
require_once('fns_book_sc.php');
session_start();

do_html_header('Insert Book');
if (check_admin_user()) {
	display_book_form();
}
else{
	echo "<p><span>Warning:</span>You not the adminuser!";
}
display_button('admin.php','admin','Back to Admin menu');
do_html_footer();
?>