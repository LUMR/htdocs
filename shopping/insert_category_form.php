<?php 
require_once('fns_book_sc.php');
session_start();

do_html_header('Add Category');
if (check_admin_user()) {
	display_cate_form();
	display_button('admin.php','admin','Admin Menu');
}else{
	echo "<p>You are not authorized to enter the administration area.</p>";
	display_button('index.php','index','Home');
}

do_html_footer();

?>