<?php 
function check_filled(array $array){
	foreach ($array as $value) {
		if (!isset($value)) {
			return false;
		}
	}
	return true;
}

?>