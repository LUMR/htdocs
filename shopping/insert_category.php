<?php 
require_once('fns_book_sc.php');
session_start();

do_html_header('Add Category');

if (check_filled($_POST)) {
	$catid = $_POST['catid'];
	$catename = $_POST['catename'];
	insert_category($catid,$catename);
}
else{
	echo "<p>You haven't enter all area.</p>";
	display_button('insert_cate_form.php','form','BACK');
}

do_html_footer();
?>