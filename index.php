<?php
// one only
require 'vendor/autoload.php';

try{
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();
}catch( Exception $e ){

	print $e->getMessage();

	exit;
}

try{
	$type = 'private';
	if( isset($_GET['type']) && in_array($type, ['internal','private','public']) ){
		$type = $_GET['type'];
	}

	// private
	if( in_array($type, ['internal','private']) ){
		$config = [
			'domain'=>getenv('EGNYTE_DOMAIN'),'client_id'=>getenv('EGNYTE_PRIVATE_CLIENT_ID'),
			'username'=>getenv('EGNYTE_USERNAME'),'password'=>getenv('EGNYTE_PASSWORD')
		];
	}else{
	// public	
		$config = ['domain'=>getenv('EGNYTE_DOMAIN'),'client_id'=>getenv('EGNYTE_PUBLIC_CLIENT_ID')];
	}

	//print_r($config); 

	//exit;

	$egnyte = new Egnyte\Egnyte($type, $config);

	//$egnyte->test();
}catch( Exception $e ){

	print $e->getMessage();
}	