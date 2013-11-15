<?php
// HttpPost.class.php

/**
 * This class sends and receives HTTP data to a web server
 * It uses cURL to transmit HTTP headers and POST to the server
 * then retrieve the result from the server
 */
class HttpPost {
	public $url;
	public $headers;
	public $postString;
	public $postParameters;
	public $getParameters;
	public $httpResponse;

	public $ch;

	/**
	 * Use cURL to send data to to a web server
	 */
	public function __construct($url) {
	         $this->url = $url;
	         $this->ch = curl_init( $this->url );
	         curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, false );
	         curl_setopt( $this->ch, CURLOPT_HEADER, false );
	         curl_setopt( $this->ch, CURLOPT_RETURNTRANSFER, true );
	}


	/**
	 * close the curl connection
	 */
	public function __destruct() {
		curl_close($this->ch);
	}    
	
	/**
	 * Set the HTTP headers
	 * 
	 * @param $headers an array of headers
	 */
	public function setHeaders( $headers ) {
		$this->headers = $headers;
		curl_setopt( $this->ch, CURLOPT_HTTPHEADER, $headers );
	}
	
	/**
	 * Add the post parameters
	 */
	public function addPostParameter($key, $value) {
		$this->postParameters[$key] = $value;
		$this->setPostData($this->postParameters);
	}
	
	
	/**
	 * Set the POST field
	 *
	 * @param $postString an url encoded string
	 */
	public function setRawPostData( $postString ) {
		$this->postString = $postString;
		curl_setopt( $this->ch, CURLOPT_POST, true );
		curl_setopt( $this->ch, CURLOPT_POSTFIELDS, $this->postString );
	}
	
	/**
	 *  Set the POST data for the request
	 * 
	 * @param $params an associative array of POST parameters
	 */
	public function setPostData( $params ) {
		$this->postString = http_build_query($params);
		// http_build_query encodes URLs, which breaks POST data
		$this->setRawPostData( urldecode(http_build_query( $params )) );
	}

	/**
	 * send the HTTP request to the server
	 */
	public function send() {
		$this->httpResponse = curl_exec( $this->ch );
	}



}

?>



/**
 * Because I'm a nice guy, I'm making a function to
 * let you print out this class in HTML to see what's going on
 */
public function toHTML() {
	$output[] =  "<div class='httppost'>";
	$output[] = "<div class='url'>".$this->url."</div>";
	if ($this->headers) {
	$output[] = "<dl class='headers'>";
	$output[] = "<dt>Headers</dt>";
	foreach ($this->headers as $key=>$val) {
		$output[] = "<dd>".$val."</dd>";
	}
	$output[] = "</dl>";
	} 
	
	if ($this->postString) {
	$output[] = "<dl class='poststring'>";
	$output[] = "<dt>POST</dt>";
	$output[] = "<dd>".$this->postString."</dd>";
	$output[] = "</dl>";
	}
	
	
	if ($this->httpResponse) {
	$output[] = "<dl class='response'>";
	$output[] = "<dt>Response</dt>";
	$output[] = "<dd>".$this->httpResponse."</dd>";
	$output[] = "</dl>";
	}
	$output[] = "</div>";
	
	$retval = implode("\n",$output);
	
	return $retval;
}

