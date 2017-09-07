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
	// type
	$type = getenv('EGNYTE_APP_TYPE','private');
	if( isset($_GET['type']) && in_array($type, ['internal','private','public']) ){
		$type = $_GET['type'];
	}

	// private
	if( in_array($type, ['internal','private']) ){
		$config = [
			'domain'=>getenv('EGNYTE_DOMAIN'),'client_id'=>getenv('EGNYTE_CLIENT_ID'),
			'username'=>getenv('EGNYTE_USERNAME'),'password'=>getenv('EGNYTE_PASSWORD')
		];
	}else{
	// public	
		$config = ['domain'=>getenv('EGNYTE_DOMAIN'),'client_id'=>getenv('EGNYTE_CLIENT_ID')];
	}

	// set oauth_token
	$config['oauth_token'] = getenv('EGNYTE_OAUTH_TOKEN');

	// init
	$egnyte = new Egnyte\Egnyte($type, $config);

	// run
	$egnyte->runTests();

}catch( Exception $e ){

	print 'Error: '.$e->getMessage();
}	