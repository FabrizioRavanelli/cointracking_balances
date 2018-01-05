<?php

require_once( '../wp-config.php' );

function cointracking($method, array $par = array()) {
	// API data
	$key = API_KEY; // YOUR API KEY
	$secret = API_SECRET; // YOUR API SECRET

	$par['method'] = $method;
	$par['nonce'] = time();

	$post_data = http_build_query($par, '', '&');
	$sign = hash_hmac('sha512', $post_data, $secret);

	$headers = array(
		'Key: '.$key,
		'Sign: '.$sign
	);

	// curl
	static $ch = null;
	if (is_null($ch)) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; CoinTracking PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
	}
	curl_setopt($ch, CURLOPT_URL, API_URL);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	$res = curl_exec($ch);

	if ($res === false) throw new Exception('API ERROR - No reply: '.curl_error($ch));
	$json = json_decode($res, true);
	if (!$json) throw new Exception('API ERROR - Invalid data received, please check connection and API data');
	return $json;
}

?>