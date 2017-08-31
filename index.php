<?php
// one only
require 'vendor/autoload.php';
//header('Content-Type: text/html; charset=utf-8');


$config = ['domain'=>'','client_id'=>'','username'=>'','password'=>''];

try{
	$egnyte = new Egnyte\Egnyte('internal', $config);

	$egnyte->test();
}catch( Exception $e ){

	print $e->getMessage();
}	