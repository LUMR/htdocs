<?php 
function login($username,$passwd){
	$conn = db_connect();
	$query = "select username,passwd from admin where username = '$username'";
	$result = $conn->query($query);
	$num = $result->num_rows;
	global $msg;
	if ($rows = $result->fetch_object()) {
		if (sha1($passwd) == $rows->passwd) {
			return true;
		}
		else{
			$msg = "The password is wrong!";
			return false;
		}
	}
	else{
		$msg = "No this user!";
		return false;
	}
}


function check_admin_user(){
	if (isset($_SESSION['admin_user'])) {
		return true;
	}
	else{
		return false;
	}
}


function display_admin_menu(){
	display_button('insert_category_form.php','category','Add a new category');
	display_button('insert_book_form.php','book','Add a new book');
	display_button('logout.php','logout','Log Out');
}


function read_table($field,$table){
	$conn = db_connect();
	$query = "select $field from $table";
	$result = $conn->query($query);
	$rows = array();
	if ($result->num_rows) {
		for ($i=0; $row = $result->fetch_assoc(); $i++) { 
			$rows[$i] = $row;
		}
		return $rows;
	}
	else{
		return false;
	}
}


function read_book_details($isbn){
	$conn = db_connect();
	$query = "select * from books where isbn = '$isbn'";
	$result = $conn->query($query);
	$rows = array();
	if ($result->num_rows) {
		$rows = $result->fetch_assoc();
		return $rows;
	}
	else{
		return false;
	}
}


function insert_book($isbn,$title,$author,$catid,$price,$description,$image){
	$conn = db_connect();
	$query = "insert books values
			  ('$isbn','$author','$title','$catid','$price','$description','$image')";
	if ($result = $conn->query($query)) 
		return true;
	else{
		global $mysqli_err;
		$mysqli_err = $conn->error;
		return false;
	}
}


function update_book($old_isbn,$isbn,$title,$author,$catid,$price,$description,$image){
	$conn = db_connect();
	$query = "update books set
			  isbn='$isbn',author='$author',title='$title',catid='$catid',price='$price',description='$description',image='$image'
			  where isbn = '$old_isbn'";
	if ($result = $conn->query($query)) 
		return true;
	else{
		global $mysqli_err;
		$mysqli_err = $conn->error;
		return false;
	}
}


function insert_category($catid,$catename){
	$conn = db_connect();
	$query = "insert categories values
				('$catid','$catename')";
	$result = $conn->query($query);
	if ($result) {
		echo "<b>Add category success!</b>";
	}
	else{
		echo "<b>FALSE</b><p>".$conn->error."</p>";
	}
}


function display_book_form($book=array(),$action="insert_book.php"){
	@$isbn = $book['isbn'];
	@$title = $book['title'];
	@$author = $book['author'];
	@$image = $book['image'];
	@$catid = $book['catid'];
	@$price = $book['price'];
	@$description = $book['description'];
echo"
	<form method=\"post\" action=\"$action\" enctype=\"multipart/form-data\">
		<input type=\"hidden\" name=\"image\" value=\"$image\">
		<table>
			<tr>
				<td>ISBN:</td>
				<td><input type=\"text\" name=\"isbn\" size=\"16\" value=\"$isbn\"></td>
			</tr>
			<tr>
				<td>Book Title:</td>
				<td><input type=\"text\" name=\"title\" value=\"$title\"></td>
			</tr>
			<tr>
				<td>Book Author:</td>
				<td><input type=\"text\" name=\"author\" value=\"$author\"></td>
			</tr>
			<tr>
				<td>Images:</td>
				<td><input type=\"file\" name=\"book_images\" accept=\"image/*\"></td>
			</tr>
			<tr>
				<td>Category</td>
				<td>
				<select name=\"catid\">";

			if($rows = read_table('catid,catname','categories')){
				foreach ($rows as $category) {
					if($catid != $category['catid'])
					echo "<option value=\"".$category['catid']."\">".$category['catname']."</option>\n";
					else
						echo "<option value=\"".$category['catid']."\" selected=\"selected\">".$category['catname']."</option>\n";
				}
			}
			else{
				echo "<option value=\"null\">null</option>\n";
			}

echo				"</select>
				</td>
			</tr>
			<tr>
				<td>Price:</td>
				<td><input type=\"text\" name=\"price\" value=\"$price\"></td>
			</tr>
			<tr>
				<td>Description:</td>
 				<td><textarea name=\"description\" rows=\"4\" cols=\"20\">$description</textarea></td>
			</tr>
			<tr>
				<td><input type=\"submit\" name=\"add book\" value=\"SAVE\"></td>
			</tr>
		</table>
	</form>
</div>";

}


function save_images($isbn){
	if ($_FILES['book_images']['error'] > 0) {
		return false;
		}

// Does the file have the right MiMe type?
	if (!strstr($_FILES['book_images']['type'],'image')) {
		echo "Problem:file is not image or gif,it is".$_FILES['book_images']['type'];
		return false;
	}

// put the file where we'd like it
	$filetype = explode('.', $_FILES['book_images']['name']);
	$filename = "$isbn.".$filetype[1];
	$upfile = "./book_pictures/$filename";

	if (is_uploaded_file($_FILES['book_images']['tmp_name'])) {
		if (!move_uploaded_file($_FILES['book_images']['tmp_name'], $upfile)) {
			echo "Problem:Could not move file to destrination directory";
			return false;
		}
	}
	else{
		echo "Problem:Possible file upload attack.Filename".$_FILES['book_images']['name'];
		return false;
	}
	echo "<p>File upload Successful!</p>";

// return the image name
	return $filename;
}


function display_cate_form(){
?>
<form action="insert_category.php" method="post">
	<table>
		<tr>
			<td>Catid</td>
			<td><input type="text" name="catid"></td>
		</tr>
		<tr>
			<td>Catname</td>
			<td><input type="text" name="catename"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="send" value="Add category"></td>
		</tr>
	</table>
</form>
<?php
}


?>