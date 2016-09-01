<?php 
require_once('fns_book_sc.php');
session_start();
$msg = "";
if (@$_POST['username'] && @$_POST['passwd']) {
	$username = $_POST['username'];
	$passwd = $_POST['passwd'];
	if (login($username,$passwd,$msg)) {
		$_SESSION['admin_user'] = $username;
	}
}

do_html_header('Administration');
if (check_admin_user()) {
	echo "<p>Login as <b>".$_SESSION['admin_user']."</b></p>";
	display_admin_menu();
}
else{
	if (!$msg) 
		$msg = "<p>You are not authorized to enter the admin area.</p>";
	echo "<p>$msg</p>";
	display_button('index.php','index','Home');
	display_button('login.php','login','Login');
}
do_html_footer();
?>