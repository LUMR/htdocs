<?php 
// include our function set
include('fns_book_sc.php');

// The shopping cart needs sessions,so start one
session_start();

do_html_header('Checkout');

if ($_SESSION['cart'] && (array_count_values($_SESSION['cart']))) {
	display_cart($_SESSION['cart'],false,0);
	display_checkout_form();
}
else{
	echo "<p>There are no items in Your cart</p>";
}

display_button("show_cart.php",'continue-shopping','Continue Shopping');
display_button("add_user_form.php","add_user_date",'add user');

do_html_footer();

 ?>