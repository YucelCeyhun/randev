<?php
function jaycrypt_encode($val){

    $secredKey = "%go^d!J&a~;y+*q>'@";

    $list =  Array(
            'a' => 1,
            'b' => 1,
            'c' => 1,
            'ç' => 2,
            'd' => 2,
            'e' => 2,
            'f' => 3,
            'g' => 3,
            'h' => 4,
            'ı' => 4,
            'i' => 4,
            'j' => 5,
            'k' => 6,
            'l' => 6,
            'm' => 6,
            'n' => 7,
            'o' => 7,
            'ö' => 7,
            'p' => 8,
            'ğ' => 8,
            'r' => 8,
            's' => 9,
            'ş' => 9,
            't' => 9,
            'u' => 10,
            'ü' => 10,
            'v' => 10,
            'y' => 11,
            'z' => 11,
            '1' => 12,
            '2' => 12,
            '3' => 12,
            '4' => 13,
            '5' => 13,
            '6' => 13,
            '7' => 14,
            '8' => 14,
            '9' => 14,
			'/' => 15,
			'.' => 15,
			',' => 15,
			'-' => 16,
			'_' => 16,
			'q' => 16,
			'x' => 17
        );
         
        
//echo chr(65);

//Character to Code
//echo ord('A');
	echo $secredKey[$list[$val[0]]];
	$secredKey[$list[$val[0]]]
    }
	
	jaycrypt_encode('x');
