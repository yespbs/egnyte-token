<?php
// one only
require 'vendor/autoload.php';
//header('Content-Type: text/html; charset=utf-8');

// private xurp7z556ajxzmmahgpbrjyw
// public 8fjuhqvuqyhevrrr676755v6



try{
	$type = 'internal';
	if( isset($_GET['type']) && in_array($type, ['internal','public']) ){
		$type = $_GET['type'];
	}

	if( 'internal' == $type ){
		$config = ['domain'=>'egnyte','client_id'=>'xurp7z556ajxzmmahgpbrjyw','username'=>'yespbs','password'=>'IuIyI78a@'];
	}else{
		$config = ['domain'=>'egnyte','client_id'=>'8fjuhqvuqyhevrrr676755v6'];
	}

	$egnyte = new Egnyte\Egnyte($type, $config);

	$egnyte->test();
}catch( Exception $e ){

	print $e->getMessage();
}	