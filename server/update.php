<?php
	include "functions.php";

	$_status['time'] = get_time();
	$_status['today'] = true;
	$_status['status'] = [true, 200];

	$_config = file_get_contents($work_dir. "/config.json");
	echo $_config;
	$config = json_decode($_config);

//	print_r($config);

	foreach($config as $uuid => $child_status) { 
//		$size = count( $child_status -> Status );
		$_last_status = file_get_contents($work_dir . "/server/" . $uuid . ".json");
		$last_status = json_decode($_last_status);

		for($i = 43; $i >= 1; $i --) 
			$child_status -> Status[$i] = $child_status -> Status[$i - 1];

		$child_status -> Status[0] = (int)($last_status -> today && get_status($uuid) && $last_status -> status[0] ); 
		

		$status_file = fopen($work_dir . "/server/" . $uuid . ".json", "w") or die("Unable to open file!");
		fwrite($status_file, json_encode( $_status ));
	}

	$status_file = fopen($work_dir . '/config.json', "w") or die("Unable to open file!");
	fwrite($status_file, json_encode( $config ));
