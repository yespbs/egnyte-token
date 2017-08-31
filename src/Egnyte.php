<?php
namespace Egnyte;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Egnyte{
	/**
	 * @var array
	 */
	private $type = 'public'; // public|internal

	/**
	 * @var array
	 */
	private $config = [];  

	/**
	 * @var object
	 */ 
	private $client = null;

	/**
	 * @var boolean
	 */
	private $debug = true;  

	/**
	 * @var string
	 */
	private $resource = '';  

	/**
	 * @todo
	 */ 
	public function __construct( $type='public', $config=null )
	{
		// log context
		$context = ['context'=>'Egnyte::'.__FUNCTION__];

		// set config
		$this->setConfig( $config );

		// oauth
		$this->getOauthToken();
	}

	/**
	 * set client
	 */ 
	public function setClient()
	{
		// log context
		$context = ['context'=>'Egnyte::'.__FUNCTION__];

		// base uri
		$base_uri = sprintf('https://%s.egnyte.com/', $this->config['domain']);
		
		// http client
		$this->client = new \GuzzleHttp\Client(['base_uri' => $base_uri]);

		// self to chain
		return $this;
	}

	/**
	 * get client
	 */ 
	public function getClient()
	{

		if( ! $this->client )
			$this->setClient();

		return $this->client;
	}

	/**
	 * set config
	 */
	public function setConfig( $config )
	{
		// set
		if( is_array($config) )
			$this->config = $config;

		// self to chain
		return $this;
	}

	/**
	 * set debug
	 */ 
	public function setDebug( $debug )
	{
		$this->debug = $debug;

		// self to chain
		return $this;
	}

	/**
	 * set debug
	 */ 
	public function getDebug()
	{
		return $this->debug;
	}

	/**
	 * @todo
	 */ 
	public function test(){

		print_r( $this->config );
	}

	/**
	 * @todo
	 */ 
	public function getOauthToken(){

		if( isset($this->config['oauth_token']) && ! empty($this->config['oauth_token']) ) 
			return;

		$headers = ['Content-Type'=>'application/x-www-form-urlencoded'];
		
		$query = [
			'client_id'=>$this->config['client_id'],
			'username'=>$this->config['username'],
			'password'=>$this->config['password'],
			'grant_type'=>'password',
			'scope' => implode(' ', ['Egnyte.filesystem','Egnyte.link','Egnyte.user']),
		];

		$this->resource = 'puboauth/token';

		$response = $this->makeRequest('POST', $query, $headers);

		pr($response);

		if( isset($response['access_token']) && ! empty($response['access_token']) ){

			$this->config['oauth_token'] = $response['access_token'];
			
		}

		echo 'done: '.$this->config['oauth_token'];
	}

	/**
	 * @todo
	 * 
	 * @deprecated
	 */ 
	private function hasResponse( $response, $status = 'Success' )
	{
		// check
		if( isset($response['Status']) && $status == $response['Status'] ){
			// return Data
			if( isset($response['Data']) ){
				return $response['Data'];
			}

			// whatever
			return $response;
		}	

		return null;
	}

	/**
	 * @todo
	 */ 
	private function makeRequest( $method='GET', $query=null, $headers=null ){
		// log context
		$context = ['context'=>'Egnyte::'.__FUNCTION__];

		// fetch
		try {
			
			// set options
			$options = [];

			// query
			if( ! is_null($query) ){
				if( 'GET' == $method ){// GET
					$options['query'] = $query;
				}elseif( 'POST' == $method ){// POST
					$options['form_params'] = $query;
				}else{// PUT
					$options['body'] = $query;
				}
			}

			// headers if set
			if( ! is_null($headers) ){
				$options['headers'] = $headers;
			}

			// debug mode
			// $options['debug'] = true;

			// call
			$response = $this->getClient()->request($method, $this->resource, $options);

			// get body
			$body = $response->getBody();

			// response
			$response = json_decode($body, true);

			// debug
			if( $this->getDebug() ){
				/*// log
				\Log::debug( 'request: '. $method . ' resource: '. $this->resource, $context );
				// log
				\Log::debug( 'options: '. pr($options, true), $context );
				// log	
				\Log::debug( 'response:'. pr($response, true), $context );*/

				// reset since we are using a singleton
				$this->setDebug( false );
			}	

			// return decoded
			return $response;
			//return new CFResponse( $response );
		}catch (RequestException $e) {
		// log	
		    /*\Log::error( $e->getMessage(), $context );*/

		    // error
		    throw new \Exception( $this->resource . ' Egnyte request error! '. $e->getMessage(), $e->getCode() );
		}catch( Exception $e ){

			// error
		    throw new \Exception( $this->resource . ' Egnyte error! '. $e->getMessage(), $e->getCode() );
		}

		return null;
	}


}