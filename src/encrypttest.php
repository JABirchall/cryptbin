<?php

$key = "E4HD9h4DhS23DYfhHemkS3Nf";// 24 bit Key
$iv = "fYfhHeDmfYfhHeDmfYfhHeDmfYfhHeDm";// 36 bit IV
$input = "This is an interface to the mcrypt library, which supports a wide variety of block algorithms such as DES, TripleDES, Blowfish (default), 3-WAY, SAFER-SK64, SAFER-SK128, TWOFISH, TEA, RC2 and GOST in CBC, OFB, CFB and ECB cipher modes. Additionally, it supports RC6 and IDEA which are considered non-free. CFB/OFB are 8bit by default. ";// text to encrypt
$bit_check=8;// bit amount for diff algor.

$str= encrypt($input,$key,$iv,$bit_check);
echo "Start: ".$input."\n\n - Encrypted: ".$str."\n\n - Decrypted: ".decrypt($str,$key,$iv,$bit_check);

function encrypt($text,$key,$iv,$bit_check) {
	$text_num =str_split($text,$bit_check);
	$text_num = $bit_check-strlen($text_num[count($text_num)-1]);
	for ($i=0;$i<$text_num; $i++) {
		$text = $text . chr($text_num);
	}
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
	mcrypt_generic_init($cipher, $key, $iv);

	$decrypted = mcrypt_generic($cipher,$text);
	mcrypt_generic_deinit($cipher);
	return base64_encode($decrypted);
}

function decrypt($encrypted_text,$key,$iv,$bit_check){
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CFB,'');
	mcrypt_generic_init($cipher, $key, $iv);
	$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_text));
	mcrypt_generic_deinit($cipher);
	$last_char=substr($decrypted,-1);
	for($i=0;$i<$bit_check-1; $i++){
	    if(chr($i)==$last_char){
	        $decrypted=substr($decrypted,0,strlen($decrypted)-$i);
	        break;
	    }
	}
	return $decrypted;
}