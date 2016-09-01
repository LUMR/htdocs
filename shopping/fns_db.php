<?php 
function db_connect(){
	$conn = new mysqli('localhost','webuser','wwwlumr','book_sc');
	if (!$conn) {
		echo "<p class=\"warning\">Connect to database:".$conn->connect_error."</p>";
		return false;
	}
	$conn->autocommit(true);
	return $conn;
}

function db_result_to_array($result){
	$res_array = array();
	for ($count=0; $row = $result->fetch_assoc(); $count++) { 
		$res_array[$count] = $row;
	}
	return $res_array;
}
 ?>
