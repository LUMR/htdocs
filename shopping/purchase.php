<?php 
include('fns_book_sc.php');
session_start();

do_html_header('Checkout');

// create short variable names
$name = $_POST['name'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];

// if filled out
if ($_SESSION['cart'] && check_filled($_POST)) {
	// able to insert into database
	if (insert_order($_POST) != false) {
		// display cart,not allowing changes and without pictures
		display_cart($_SESSION['cart'],false,0);

		display_shipping(calculate_shipping_cost());

		// get credit card details
		display_card_form($name);

		display_button('show_cart.php','continue-shopping','Continue Shopping');
		}
	}
	else{
		echo "<p class=\"warning\">You did not fill in all the fields,please try again.</p>";
		display_button('checkout.php','back','Back');
	}

	do_html_footer();

?>