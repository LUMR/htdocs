<?php 
require_once('fns_book_sc.php');
session_start();

do_html_header('Logout');
if (check_admin_user()) {
	unset($_SESSION['admin_user']);
	echo "<p>Logout successful!";
}
else{
	echo "You haven't login.";
}
display_button('index.php','continue','Home');
do_html_footer();
?>