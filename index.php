<?php
// one only
require 'vendor/autoload.php';
//header('Content-Type: text/html; charset=utf-8');

// private xurp7z556ajxzmmahgpbrjyw
// public 8fjuhqvuqyhevrrr676755v6

$config = ['domain'=>'egnyte','client_id'=>'xurp7z556ajxzmmahgpbrjyw','username'=>'yespbs','password'=>'IuIyI78a@'];

try{
	$egnyte = new Egnyte\Egnyte('internal', $config);

	$egnyte->test();
}catch( Exception $e ){

	print $e->getMessage();
}	