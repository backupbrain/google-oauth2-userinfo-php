<?php
// classes/Google_OAuth2.class.php



/**
 * Authenticate with the Google servers using OAuth2
 * https://accounts.google.com/o/oauth2/auth
 * 
 */
class Google_OAuth2 {
	
	const URL = 'https://accounts.google.com/o/oauth2/auth';
	public $authenticated = false;

	
	// these variables will be encoded into a GET query
	public $response_type = "code",
		$access_type,
		$client_id,
		$redirect_uri;
	public $scopes = array();
		
	/**
	 * add a URL OAuth2 scope to the scope list.
	 */
	public function addScope($scope) {
		$this->scopes[] = $scope;
	}
	
	/**
	 * make the OAuth2 login request.  
	 * This is done by forwarding the user
	 * to a login screen
	 */
	public function authenticate() {
		$scope = implode(" ", $this->scopes);
		
		$query_params = array(
			'response_type' => $this->response_type,
			'access_type' => 'offline',
			'client_id' => $this->client_id,
			'redirect_uri' => $this->redirect_uri,
			'scope' => $scope
		);
		
		$forward_url = self::URL . '?' . http_build_query($query_params);
		
		header('Location: ' . $forward_url);
	}


}


?>