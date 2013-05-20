<?php

//This is a series of functions that can be used to randomize an array in a
//manner that keeps associative elements associated correctly, but mixed-up,
//and non-associative (ie elements with integer keys) randomized but with
//re-assigned keys to their proper location.

//Function: test_key
//Very simply, this function checks the new assignment in an array and sees if
//it is currently occupied. If it is, it moves along to the next available slot,
//modulos the amount of elements in the source array.

function test_key($count, $midsort_array, $key) {
	$new_key = $key % $count;
	if($midsort_array[$new_key]) {
		//new key already exists, so find next available slot recursively
		$key = ($new_key + 1) % $count;
		$new_key = test_key($count, $midsort_array, $key);
	}
	return $new_key;
}

//Function: unsort
//This is our main function. We use rand() because I'm not terribly familiar
//with any other random functions, and also because it's not like we're randomly
//picking locations on a map and need special functionality. 

function unsort($array) {

	$midsort_array = array();
	$unsort_array = array();
	
	foreach($array as $k => $b) {
		//randomly pick new key and see if it's available
		$new_key = test_key(count($array), $midsort_array, rand(0, count($array)));
		$midsort_array[$new_key] = array(
			'key' => $k,
			'value' => $b
		);
	}
	ksort($midsort_array);
	//now read the randomly-ordered keys and values into the new array. If a key
	//is an integer, reassign it. If a key is anything else, use that as the key
	foreach($midsort_array as $k => $b) {
		if(is_int($b['key'])) {
			$unsort_array[$k] = $b['value'];
		} else {
			$unsort_array[$b['key']] = $b['value'];
		}
	}
		
	return $unsort_array;
}

//this is our test array
$input_array = array(
	'one',
	'two',
	'three' => 'three',
	'four',
	'five' => 'five',
	'six' => 'six',
	'seven',
	'eight' => 'eight',
	'nine' => 'nine',
	'ten'
);

//and here are our results

print('Original (' . count($input_array) . ') : <br />');

print_r($input_array);

print('<br />');

$new_array = unsort($input_array);

print('Complete (' . count($new_array) . ') : <br />');

print_r($new_array);

?>