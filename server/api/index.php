<?php
	include '../functions.php';

	$uuid = $_POST['uuid'];
	$status = $_POST['status'];

	if( $uuid == null || $status == null )
		die("参数不正确");
	if( !file_exists( $work_dir . "/server/" . $uuid . ".json" ) )
		die("不允许的 UUID");

	$save = true;
	if( preg_match('/50\d/', $status) || $status == '-1' || $status == '0' )
		$save = false;

	$_last_status = file_get_contents( $work_dir . "/server/" . $uuid . ".json" );
	$last_status = json_decode($_last_status);

	$_status['time'] = get_time();
	$_status['today'] = ($last_status -> today && get_status($uuid) && $save);
	$_status['status'] = [$save, (int)$status];


	$status_file = fopen($work_dir . "/server/" . $uuid . ".json", "w") or die("打开文件错误！");
	fwrite($status_file, json_encode( $_status ));
