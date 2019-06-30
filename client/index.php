<?php 
	$work_dir = '/var/www/cli/';
	$server = 'https://api.woshiluo.site/clients/api/';

	$_clients = file_get_contents($work_dir . 'config.json');
	$clients = json_decode($_clients);

 	$size = count( $clients );
 	for($i = 0; $i < $size; $i ++) {
 		if( $clients[$i] -> type ) {
 			$curl = curl_init();
 			curl_setopt($curl, CURLOPT_URL, $clients[$i] -> address);
 			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 			curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:67.0) Gecko/20100101 Firefox/67.0');
 			curl_exec($curl);
 			$clients_code = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
 			if( (int)curl_getinfo($curl, CURLINFO_HTTP_CODE)['total_time_us'] >= 9000000 )
 				$status_code = -1;
 		}
 		else {
 			$status_code = 200;
 		}
 
 		$curl = curl_init();
 		curl_setopt($curl, CURLOPT_URL, $server);
 		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 		curl_setopt($curl, CURLOPT_POST, 1);
 		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64; rv:67.0) Gecko/20100101 Firefox/67.0');
 		$post_data = array(
 			"uuid" => $clients[$i] -> uuid,
			"status" => $status_code
 		);
 		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
 		$result = curl_exec($curl);
 	}
?>
