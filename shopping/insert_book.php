<?php 
include('fns_book_sc.php');
session_start();

do_html_header('Add Book');

if (check_admin_user()) {
	if (check_filled($_POST)) {
		$isbn = $_POST['isbn'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$catid = $_POST['catid'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$mysqli_err = "";
		if (insert_book($isbn,$title,$author,$catid,$price,$description,save_images($isbn))) {
			echo "<p>Book <em>".stripcslashes($title)."</em> was added to the database.</p>";
		}
		else{
			echo "<p>Book <em>".stripcslashes($title)." could not be added to the database.</p>";
			echo $mysqli_err;
		}
	}
	else{
		echo "<p>you have not filled out the form.Please try again.</p>";
		display_button('admin.php','admin','Admin Menu');
	}
}
else{
	echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>