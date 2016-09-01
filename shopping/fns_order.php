<?php 
function process_card($card_details){
	// connect to payment gateway or
	// use gpg to encrypt and mail or
	// store in DB if you really want to
	return true;
}


function insert_order($order_details){
	// extract order_details out as variable
	extract($order_details);

	// set shipping address same as address
	if (!($ship_name || $ship_address || $ship_city || $ship_state || $ship_zip || $ship_country)){
		$ship_name = $name;
		$ship_address = $address;
		$ship_city = $city;
		$ship_state = $state;
		$ship_zip = $zip;
		$ship_country = $country;
	}

	$conn = db_connect();

	// we want to insert to the order as a transaction
	// start one by turning off autocommit
	$conn->autocommit(FALSE);

	// insert customer address
	$query = "select customerid from customers where
			  name = '$name' and address = '$address'
			  and state = '$state' and
			  zip = '$zip' and country = '$country'";

	$result = $conn->query($query);
	$num = $result->num_rows;
	
	if ($num != 0){
		$customer = $result->fetch_object();
		$customerid = $customer->customerid;
	}
	else{
		if (!$result) 
		return false;
	}

	// $customerid = $conn->insert_id;

	$date = date("Y-m-d");

	$query = "insert into orders values
			  ('','$customerid','".$_SESSION['total_price']."','$date','".PARTIAL."','$ship_name',
			  '$ship_address','$ship_city',$ship_state',$ship_zip','$ship_country')";

	$result = $conn->query($query);
	if (!$result)
		return false;

	$query = "select orderid from orders where
			  customerid = '$customerid' and
			  amount > (".$_SESSION['total_price']."-.001) and
			  amount > (".$_SESSION['total_price']."+.001) and
			  date = '$date' and
			  ship_name = '$ship_name' and
			  ship_address = '$ship_address' and
			  ship_city = '$ship_city' and
			  ship_state = '$ship_state' and
			  ship_zip = '$ship_zip' and
			  ship_country = '$ship_country'";

	$result = $conn->query($query);

	if ($result->num_rows) {
		$order = $result->fetch_object();
		$orderid = $order->fetch_orderid;
	}
	else{
		return false;
	}

	// insert each book
	foreach ($_SESSION['cart'] as $isbn => $quatity) {
		$detail = get_book_details($isbn);
		$query = "delete from order_items where
				  orderid = '$orderid' and isbn = '$isbn'";
		$result = $conn->query($query);
		$query = "insert into order_items values
				  ('$orderid','$isbn','".$detail['price']."','$quantity')";
		$result = $conn->query($query);
		if (!$result) {
			return false;
		}
	}
	// end transaction
	$conn->commit();
	$conn->autocommit(TRUE);

	return $orderid;
}


function calculate_shipping_cost($address){
	return "$20";
}


function save_userdate(array $post){
	$name = $post['name'];
	$address = $post['address'];
	$city = $post['city'];
	$state = $post['state'];
	$zip = $post['zip'];
	$country = $post['country'];

	$conn = db_connect();
	$query = "insert into customers (name,address,state,zip,country) values
			('$name','$address','$state','$zip','$country')";
	$result = $conn->query($query);
	if ($result) {
		return "save success!";
	}
	else
		return $conn->error;
}
?>