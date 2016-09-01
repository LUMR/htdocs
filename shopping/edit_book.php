<?php 
require 'fns_book_sc.php';
session_start();

$old_isbn = $_GET['old_isbn'];
do_html_header('Edit Book');
$mysql_err = "";
if (check_admin_user()) {
	if (check_filled($_POST)) {
		$isbn = $_POST['isbn'];
		$title = $_POST['title'];
		$author = $_POST['author'];
		$image = $_POST['image'];
		$catid = $_POST['catid'];
		$price = $_POST['price'];
		$description = $_POST['description'];

		if ($isbn != $old_isbn) {
			$image_type = explode('.', $image);
			$old_image = $image;
			$image = "$isbn.".$image_type[1];
			rename("book_pictures/$old_image", "book_pictures/$image");
		}

		if ($image_new = save_images($isbn)) {
			// unlink("book_pictures/$image");
			$image = $image_new;
		}

		if(update_book($old_isbn,$isbn,$title,$author,$catid,$price,$description,$image)){
			echo "<p>update successful</p>";
		}
		else{
			echo "<p>update false.</p>";
			echo $mysqli_err;
		}
	}
}
else{
	echo "<p>You haven't login in.</p>";
}
display_button('index.php','index','HOME');
do_html_footer();

?>