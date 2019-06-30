<?php
	include './functions.php';

	$_status['time'] = get_time();
	$_status['today'] = false;
	$_status['status'] = [false, -2];

	$_config = file_get_contents($work_dir . "/config.json");
	$config = json_decode($_config);

	foreach($config as $uuid => $child_status) {
//		$size = count( $child_status -> Status );
		for($i = 0; $i < 44; $i ++)
			$child_status -> Status[$i] = -1;

		if( !file_exists( $work_dir . "/server/" . $uuid . ".json" ) ) {
			$status_file = fopen($work_dir . "/server/" . $uuid . ".json", "w") or die("Unable to open file!");
			fwrite($status_file, json_encode( $_status ));
		}
	}


	$status_file = fopen($work_dir . '/config.json', "w") or die("Unable to open file!");
	fwrite($status_file, json_encode( $config ));
