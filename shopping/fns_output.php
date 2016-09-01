<?php 
function do_html_header($title){
	if (!isset($_SESSION['items']))
		$_SESSION['items'] = 0;
	if (!isset($_SESSION['total_price']))
		$_SESSION['total_price'] = 0.00;
	if (!isset($_SESSION['cart']))
		$_SESSION['cart'] = array();
	echo '<!DOCTYPE HTML>
		  <html>
		  <head>
		  <title>'.$title.'</title>
		  <link rel="stylesheet" type="text/css" href="index.css">'."
		  </head>
		  <body>
		  <div class=\"header\">
		  <h1>Book-O-Rama</h1>
		  <table>
		  <tr>
		  <td><p>Total Items = <span>".$_SESSION['items'].'</span></p></td>
		  <td><p>Total Price = <span>'.$_SESSION['total_price']."</span></p></td>
		  </tr>
		  </table>
		  <a href=\"show_cart.php\"><input type=\"button\" name=\"show_cart\" value=\"View Cart\"></a><br>
		  <b>$title</b>
		  </div>";
}


function do_html_footer(){
?>
<div class="footer">
	<p>Make by <span>LUMR</span></p>
</div>
<?php
}


function display_button($href,$name,$value){
	echo "<a href=\"$href\"><input type=\"button\" name=\"$name\" value=\"$value\"></a>";
}


function display_categories($cat_array){
	if (!is_array($cat_array)) {
		echo "<p>No categories currently available</p>";
		return;
	}
	echo "<ul>";
	foreach ($cat_array as $row) {
		$url = "show_cat.php?catid=".$row['catid'];
		$title = $row['catname'];
		echo "<li>";
		do_html_url($url,$title);
		echo "</li>";
	}
	echo "</ul>";
	echo "<hr/>";
}


function display_books($book_array){
	if (!is_array($book_array)) {
		echo "<p>No books currently available</p>";
		return;
	}
	echo "<ul>";
	foreach ($book_array as $row) {
		$url = "show_book.php?isbn=".$row['isbn'];
		$title = $row['title'];
		echo "<li>";
		do_html_url($url,$title);
		echo "</li>";
	}
	echo "</ul>";
	echo "<hr/>";
}


function display_cart($cart,$change = true,$images = 1){
	// display items in shopping cart
	// optionally allow changes (true or false)
	// optionally include images (1 -yes,0- no)
	echo "<table class=\"cart\">
		  <form action=\"show_cart.php\" method=\"post\">
		  <tr><th colspan=\"".(1+$images)."\">Item</th>
		  <th>Price</th>
		  <th>Quality</th>
		  <th>Total</th>
		  </tr>";

	// display each item as a table row
	foreach ($cart as $isbn => $qty) {
		$book = get_book_details($isbn);
		echo "<tr>";
		if ($images == true) {
			echo "<td align=\"legt\">";
			if (file_exists("book_pictures/$isbn.jpg")) {
				$size = getimagesize("book_pictures/$isbn.jpg");
				if (($size[0]>0) && ($size[1]>0)) {
					echo "<img src=\"book_pictures/$isbn.jpg\"/>";
				}
			}
			else{
					echo "&nbsp";
			}
			echo "</td>";
			}
			echo "<td align=\"left\">
				  <a href=\"show_book.php?isbn=$isbn\">".$book['title']."</a>
				  by ".$book['author']."</td>
				  <td align=\"center\">\$".number_format($book['price'],2)."</td>
				  <td align=\"center\">";

			if ($change == true) {
				echo "<input type=\"text\" name=\"$isbn\" value=\"$qty\" size=\"3\">";
			}
			else{
				echo $qty;
			}
			echo "</td>
				  <td align=\"center\">\$".number_format($book['price']*$qty,2)."</td>
				  </tr>\n";
		}
		// display total row
		echo "<tr>
			  <th colspan=\"".(2+$images).">&nbsp;</td>
			  <th align=\"center\">".$_SESSION['items']."</th>
			  <th align=\"center\">\$".number_format($_SESSION['total_price'],2)."</th></tr>";

		// display save change button
		if ($change == true) {
			echo "<tr>
				  <td colspan=\"".(2+$images)."\">&nbsp;</td>
				  <td align=\"center\">
				  	<input type=\"hidden\" name=\"save\" value=\"true\"/>
				  	<input type=\"image\" src=\"images/save-changes.gif\"
				  		border=\"0\" alt=\"Save Changes\"/>
				  </td>
				  <td>&nbsp;</td>
				  </tr>";
		}
	echo "</form></table>";
}


function display_userform(){
	?>
	<form method="post" action="insert_userdate.php">
		<h2>Your Details</h2>
		<table>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td><b>Address</b></td>
				<td><input type="text" name="address"></td>
			</tr>
			<tr>
				<td><b>City/Suburb</b></td>
				<td><input type="text" name="city"></td>
			</tr>
			<tr>
				<td><b>State/Province</b></td>
				<td><input type="text" name="state"></td>
			</tr>
			<tr>
				<td><b>Postal Code or Zip Code</b></td>
				<td><input type="text" name="zip"></td>
			</tr>
			<tr>
				<td><b>Country</b></td>
				<td><input type="text" name="country"></td>
			</tr>
			<tr><td><input type="submit" value="Save"></td></tr>
		</table>
	</form>
	<?php
}


function display_checkout_form(){
?>
	<form method="post" action="purchase.php">
		<h2>Your Details</h2>
		<table>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td><b>Address</b></td>
				<td><input type="text" name="address"></td>
			</tr>
			<tr>
				<td><b>City/Suburb</b></td>
				<td><input type="text" name="city"></td>
			</tr>
			<tr>
				<td><b>State/Province</b></td>
				<td><input type="text" name="state"></td>
			</tr>
			<tr>
				<td><b>Postal Code or Zip Code</b></td>
				<td><input type="text" name="zip"></td>
			</tr>
			<tr>
				<td><b>Country</b></td>
				<td><input type="text" name="country"></td>
			</tr>
		</table>
		<h2>Shopping Address (leave blank if as above)</h2>
		<table>
			<tr>
				<td><b>Name</b></td>
				<td><input type="text" name="ship_name"></td>
			</tr>
			<tr>
				<td><b>Address</b></td>
				<td><input type="text" name="ship_address"></td>
			</tr>
			<tr>
				<td><b>City/Suburb</b></td>
				<td><input type="text" name="ship_city"></td>
			</tr>
			<tr>
				<td><b>State/Province</b></td>
				<td><input type="text" name="ship_state"></td>
			</tr>
			<tr>
				<td><b>Postal Code or Zip Code</b></td>
				<td><input type="text" name="ship_zip"></td>
			</tr>
			<tr>
				<td><b>Country</b></td>
				<td><input type="text" name="ship_country"></td>
			</tr>
		</table>
		<p>Please press Purchase to confim your purchase,or Continue Shopping to add or remove items</p>
		<input type="submit" value="Purchase $">
	</form>
<?php
}


function do_html_url($name,$title){
	echo "<a href=\"$name\">$title</a>";
}


function display_book_details($book){
	if (is_array($book)) {
		$author = $book['author'];
		$isbn = $book['isbn'];
		$price = $book['price'];
		$description = $book['description'];
		$image = $book['image'];
echo "
		<div class=\"book_details\">
		<img src=\"book_pictures/$image\">
		<ul>
		<li><span>Author:</span>$author</li>
		<li><span>ISBN:</span>$isbn</li>
		<li><span>Our Price:</span>$price</li>
		<li><span>Description:</span>$description</li>
	</ul>
	</div>
	<hr>";
	}
}
?>
