<?php
	include './functions.php';
	include './header.php';

	$_clients = file_get_contents("./config.json");
	$clients = json_decode($_clients);

	foreach($clients as $uuid => $client) {
		$groups[ $client -> Group ][ $client -> Name ] = [ $uuid, $client -> Status ];
	}

	unset( $clients ); unset( $_clients );

	$flag = true;
	foreach($groups as $name => $client) {
		?>
			<div class="mdui-col">
				<div class="mdui-card mdui-container stauts-card">
					<div class="mdui-card-primary">
						<div class="mdui-card-primary-title"><?php echo $name; ?></div>
					</div>
					<div class="mdui-card-content">
						<div class="mdui-table-fluid mdui-shadow-1">
							<table class="mdui-table">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Status</th>
										<th>Last Update time</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$cnt = 0;
										foreach($client as $cli_name => $cli_status) {
											echo '<tr>';
											echo '<td>' . ++$cnt . '</td>';
											echo '<td>' . $cli_name . '</td>';
											$tmp = print_status( $cli_status[0] );
											$flag = $flag && $tmp;
											echo '<td>';  print_time( $cli_status[0] ); echo '</td>';
											echo '</tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
	<?php } ?>
	<?php if($flag){ ?>
		<button id="status" class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-green"><i class="mdui-icon material-icons">done_all</i></button>
	<?php }else{ ?>
		<button id="status" class="mdui-fab mdui-fab-fixed mdui-ripple mdui-color-red"><i class="mdui-icon material-icons">warning</i></button>
	<?php } ?>
		<script src="./libs/mdui-v0.4.2/js/mdui.min.js"></script>
		<script>
			var $$ = mdui.JQ;

			$$('#status').on('click', function () {
				mdui.snackbar({
					message: '<?php echo $flag? '一切正常的说': '似乎不太对的说';?>'
				});
			});
		</script>
	</body>
</html>
