<?php
	$work_dir = '/var/www/html/status';
	global $work_dir;
	function get_time() {
		list(, $time) = explode(" ", microtime());
		return (int) $time;
	}
	
	function get_status($uuid) {
		global $work_dir;
		$_client = file_get_contents( $work_dir . '/server/' . $uuid . '.json' );
		$clent = json_decode($_client);

		if( get_time() - (int)($client -> time) >= 900 ){
			return false;
		}

		return $client -> status[0];
	}

	function print_status($uuid) {
		global $work_dir;
		$_client = file_get_contents( $work_dir . '/server/' . $uuid . '.json' );
		$client = json_decode($_client);

		if( get_time() - (int)($client -> time) >= 900 ) {
			?>
				<td class="mdui-text-color-yellow"> <i class="mdui-icon material-icons">info</i> Unkown </td>
			<?php
			return false;
		}
		if( $client -> status[0] ) {
			?>
				<td class="mdui-text-color-green"><i class="mdui-icon material-icons">done</i> Online </td>
			<?php
			return true;
		}
		else {
			?>
				<td class="mdui-text-color-red"><i class="mdui-icon material-icons">error</i> Offline </td>
			<?php
			return false;
		}
	}

	function print_time($uuid) {
		global $work_dir;
		$_client = file_get_contents( $work_dir . '/server/' . $uuid . '.json' );
		$client = json_decode($_client);

		echo date('Y-m-d H:i:s', $client -> time);
	}
?>
