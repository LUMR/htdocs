<?php 
	require_once('fns_book_sc.php');
	session_start();

	$isbn = $_GET['isbn'];
	do_html_header('Edit Book');
	if (check_admin_user()) {
		$book = read_book_details($isbn);
		if (is_array($book)) {
			display_book_form($book,"edit_book.php?old_isbn=$isbn");
		}
		else{
			echo "<p>No this book.</p>";
		}
	}
	else{
		echo "<p>You haven't login the system.</p>";
	}

	display_button("show_book.php?isbn=$isbn",'Back','BACK');
	do_html_footer();
	
?>