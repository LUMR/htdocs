<?php 
// The code of book_sc
function get_categories(){
	// query database for a list of categories
	$conn = db_connect();
	$query = "select catid,catname from categories";
	$result = $conn->query($query);
	if (!$result) {
		return false;
	}
	$num_cats = $result->num_rows;
	if ($num_cats == 0) {
		return false;
	}
	$result = db_result_to_array($result);
	return $result;
}


function get_books($catid){
	// query database for a list of books
	$conn = db_connect();
	$query = "select title,isbn from books where catid = '$catid'";
	$result = $conn->query($query);
	if (!$result) {
		return false;
	}
	$num_cats = $result->num_rows;
	if ($num_cats == 0) {
		return false;
	}
	$result = db_result_to_array($result);
	return $result;
}

function get_category_name($catid){
	// query database for the name for a category id
	$conn = db_connect();
	$query = "select catname form categories where catid = '$catid'";
	$result = $conn->query($query);
	if (!$result) {
		return false;
	}
	$num_cats = $result->num_rows;
	if ($num_cats == 0) {
		return false;
	}
	$row = $result->fecth_object();
	return $row->catname;
}


function get_book_details($isbn){
	$conn = db_connect();
	$query = "select * from books where isbn = '$isbn'";
	$result = $conn->query($query);
	if ($result->num_rows == 1) {
		$row = $result->fetch_assoc();
		return $row;
	}
	else{
		return false;
	}
}


function calculate_price($cart){
	// sum total price for all items in shopping cart
	$price = 0.0;
	if (is_array($cart)) {
		$conn = db_connect();
		foreach($cart as $isbn => $qty){
			$query = "select price from books where isbn = '$isbn'";
			$result = $conn->query($query);
			if ($result) {
				$item = $result->fetch_object();
				$item_price = $item->price;
				$price += $item_price*$qty;
			}
		}
	}
	return $price;
}


function calculate_items($cart){
	// sum total items in shopping cart
	$item = 0;
	if (is_array($cart)) {
		foreach ($cart as $isbn => $qty) {
			$item += $qty;
		}
		// $items = array_sum($cart);
	}
	return $item;
}

?>

