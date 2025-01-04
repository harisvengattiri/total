<?php require_once "includes/menu.php"; ?>

<?php

$sql = "SELECT count(*) as contacts_total from customers";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$contacts_total = $row['contacts_total'];
	}
}
$sql = "SELECT count(*) as staff_total from customers where type='Staff'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$staff_total = $row['staff_total'];
	}
}

$sql = "SELECT count(*) as vehicles_total from vehicles";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$vehicles_total = $row['vehicles_total'];
	}
}

$sql = "SELECT count(*) as items_total from items";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$items_total = $row['items_total'];
	}
}


$sql = "SELECT * from customers ORDER BY id DESC LIMIT 6";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		$recent_contacts[] = $row;
	}
}
$custcntarrow = "up";
?>
<style>
	.mobile-content {
		display: none;
		padding-top: 5em;
	}

	.mobile-content p {
		font-size: 20px;
	}

	.mobile-content p span {
		font-size: 16px;
	}

	/* Styles for mobile */
	@media screen and (max-width: 768px) {
		.desktop-content {
			display: none;
		}

		.mobile-content {
			display: block;
		}
	}
</style>


<div class="app-body desktop-content">

	<!-- ############ PAGE START-->
	<div class="row-col">
		<div class="col-lg b-r">
			<div class="row no-gutter">
				<div class="col-xs-6 col-sm-3 b-r b-b">
					<div class="padding">
						<div>
							<span class="pull-right"><i class="fa fa-caret-<?php echo $custcntarrow; ?> text-primary m-y-xs"></i></span>
							<span class="text-muted l-h-1x"><i class="ion-person-stalker text-muted"></i></span>
						</div>
						<div class="text-center">
							<h2 class="text-center _600"><?php echo $contacts_total; ?></h2>
							<p class="text-muted m-b-md">Total Contacts</p>
							<div>
								<span data-ui-jp="sparkline" data-ui-options="[<?php echo $contacts_total; ?>], {type:'line', height:20, width: '60', lineWidth:1, valueSpots:{'0:':'#818a91'}, lineColor:'#818a91', spotColor:'#818a91', fillColor:'', highlightLineColor:'rgba(120,130,140,0.3)', spotRadius:0}" class="sparkline inline"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-3 b-r b-b">
					<div class="padding">
						<div>
							<span class="pull-right"><i class="fa fa-caret-<?php echo $custcntarrow; ?> text-primary m-y-xs"></i></span>
							<span class="text-muted l-h-1x"><i class="ion-network text-muted"></i></span>
						</div>
						<div class="text-center">
							<h2 class="text-center _600"><?php echo $items_total; ?></h2>
							<p class="text-muted m-b-md">Total Items</p>
							<div>
								<span data-ui-jp="sparkline" data-ui-options="[<?php echo $items_total; ?>], {type:'line', height:20, width: '60', lineWidth:1, valueSpots:{'0:':'#818a91'}, lineColor:'#818a91', spotColor:'#818a91', fillColor:'', highlightLineColor:'rgba(120,130,140,0.3)', spotRadius:0}" class="sparkline inline"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-3 b-r b-b">
					<div class="padding">
						<div>
							<span class="pull-right"><i class="fa fa-caret-<?php echo $custcntarrow; ?> text-primary m-y-xs"></i></span>
							<span class="text-muted l-h-1x"><i class="ion-settings text-muted"></i></span>
						</div>
						<div class="text-center">
							<h2 class="text-center _600"><?php echo $staff_total; ?></h2>
							<p class="text-muted m-b-md">Total Staff</p>
							<div>
								<span data-ui-jp="sparkline" data-ui-options="[<?php echo $staff_total; ?>], {type:'line', height:20, width: '60', lineWidth:1, valueSpots:{'0:':'#818a91'}, lineColor:'#818a91', spotColor:'#818a91', fillColor:'', highlightLineColor:'rgba(120,130,140,0.3)', spotRadius:0}" class="sparkline inline"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-sm-3 b-b">
					<div class="padding">
						<div>
							<span class="pull-right"><i class="fa fa-caret-<?php echo $custcntarrow; ?> text-primary m-y-xs"></i></span>
							<span class="text-muted l-h-1x"><i class="ion-android-car text-muted"></i></span>
						</div>
						<div class="text-center">
							<h2 class="text-center _600"><?php echo $vehicles_total; ?></h2>
							<p class="text-muted m-b-md">Total Vehicles</p>
							<div>
								<span data-ui-jp="sparkline" data-ui-options="[<?php echo $vehicles_total; ?>], {type:'line', height:20, width: '60', lineWidth:1, valueSpots:{'0:':'#818a91'}, lineColor:'#818a91', spotColor:'#818a91', fillColor:'', highlightLineColor:'rgba(120,130,140,0.3)', spotRadius:0}" class="sparkline inline"></span>
							</div>
						</div>
					</div>
				</div>
			</div>






			<div class="padding">

				<div class="row">
					<div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<span class="label white text-success pull-right">Latest 6 Contacts</span>
								<span class="label success pull-right">6</span>
								<h3>New Contacts</h3>
							</div>
							<div class="p-b-sm">
								<ul class="list no-border m-a-0">
									<?php foreach($recent_contacts as $recent) { ?>
									<li class="list-item">
										<a href="#" class="list-left">
											<span class="w-40 avatar danger">
												<span><?php echo ucfirst(substr($recent['name'], 0, 1)); ?></span>
											</span>
										</a>
										<div class="list-body">
											<div><a href="<?php echo BASEURL; ?>/customers?id=<?php echo $recent['id']; ?>"><?php echo $recent['name']; ?></a></div>
											<small class="text-muted text-ellipsis"><?php echo $recent['type']; ?></small>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>

						<div class="box">
							<div class="box-header">
								<span class="label white text-success pull-right">Total Sellers</span>
								<span class="label success pull-right">15</span>
								<h3>Top Sellers</h3>
							</div>
							<div class="p-b-sm">
								<ul class="list no-border m-a-0">
									<?php foreach($recent_contacts as $recent) { ?>
									<li class="list-item">
										<a href="#" class="list-left">
											<span class="w-40 avatar success">
												<span><?php echo ucfirst(substr($recent['name'], 0, 1)); ?></span>
											</span>
										</a>
										<div class="list-body">
											<div><a href="<?php echo BASEURL; ?>/customers?id=<?php echo $recent['id']; ?>"><?php echo $recent['name']; ?></a></div>
											<small class="text-muted text-ellipsis"><?php echo $recent['type']; ?></small>
										</div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>

					<!-- <div class="col-sm-6">
						<div class="box">
							<div class="box-header">
								<h3 style="color:red;"><b>Latest Salesorders to approve</b></h3>
							</div>
							<form style="padding-bottom:10px;" role="form" action="<?php // echo BASEURL; ?>/edit/po_approval" method="post">
								<div class="form-group row">
									<label for="type" align="right" class="col-sm-3 form-control-label">Sales Order</label>
									<div class="col-sm-5">
										<select name="order_refrence" class="form-control select2-multiple" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}" required>
											<option value="">Select Sales Order</option>
											<?php
											// $sql_po_appr = "SELECT * FROM `sales_order` WHERE approve != 1 ORDER BY id DESC";
											// $query_po_appr = mysqli_query($conn, $sql_po_appr);
											// while ($fetch_po_appr = mysqli_fetch_array($query_po_appr)) {
											?>
												<option value="<?php // echo $fetch_po_appr['order_referance']; ?>">PO|<?php // echo $fetch_po_appr['order_referance']; ?></option>
											<?php // } ?>
										</select>
									</div>
									<button name="submit_appr" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Approve</button>
								</div>
							</form>
						</div>
					</div> -->


				</div>
			</div>
		</div>



		<!-- ############ Sidebar Start-->


		<div class="col-lg w-lg w-auto-md white bg">
			<div>
				<div class="p-a">
					<h6 class="text-muted m-a-0">Last Login</h6>
				</div>
				<div class="list inset">


					<?php
					$username = $_SESSION['username'];
					$sql = "select * from login_log where username='$username' ORDER BY `id` DESC LIMIT 1,1";

					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							if ($row["status"] == 'success') {
					?>
								<a class="list-item" data-toggle="modal" data-target="#login-log" data-dismiss="modal">
									<div class="sl-date text-muted"><b class="label label-xs rounded success"></b> &nbsp;
										<?php echo "<b>" . strtoupper($row["time"]) . "</b><br/>from <b>" . $row["location"] . "</b><br/>with IP <b>" .
											$row["ip"] . "</b> was successfull!"; ?></div>
								</a>
							<?php
							} else {
							?>
								<a class="list-item" data-toggle="modal" data-target="#login-log" data-dismiss="modal">
									<div class="sl-date text-muted"><b class="label label-xs rounded danger"></b> &nbsp;
										<?php echo "<b>" . strtoupper($row["time"]) . "</b><br/>from <b>" . $row["location"] . "</b><br/>with IP <b>" .
											$row["ip"] . "</b> was failed!"; ?></div>
								</a>
					<?php
							}
						}
					}
					?>
					</a>
				</div>
				<div class="p-a">
					<h6 class="text-muted m-a-0">Activities</h6>
				</div>
				<div class="streamline streamline-theme m-b">
					<?php
					$sql = "select * from activity_log ORDER BY `id` DESC LIMIT 12";

					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							if ($row["process"] == 'delete') {
					?>
								<div class="sl-item b-danger">
									<div class="sl-content">
										<!--<div><?php echo strtoupper(substr($row["code"], 0, 3)) . sprintf("%04d", substr($row["code"], 3)); ?> was deleted by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>-->
										<div><?php echo strtoupper($row["code"]) ?> was deleted by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>
										<div class="sl-date text-muted"><?php echo strtoupper($row["time"]); ?></div>
									</div>
								</div>
							<?php
							} elseif ($row["process"] == 'edit') {
							?>
								<div class="sl-item b-info">
									<div class="sl-content">
										<!--<div><?php echo strtoupper(substr($row["code"], 0, 3)) . sprintf("%04d", substr($row["code"], 3)); ?> was edited by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>-->
										<div><?php echo strtoupper($row["code"]) ?> was edited by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>
										<div class="sl-date text-muted"><?php echo strtoupper($row["time"]); ?></div>
									</div>
								</div>
							<?php
							} elseif ($row["process"] == 'add') {
							?>
								<div class="sl-item b-success">
									<div class="sl-content">
										<!--<div><?php echo strtoupper(substr($row["code"], 0, 3)) . sprintf("%04d", substr($row["code"], 3)); ?> was added by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>-->
										<div><?php echo strtoupper($row["code"]) ?> was added by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>
										<div class="sl-date text-muted"><?php echo strtoupper($row["time"]); ?></div>
									</div>
								</div>
							<?php
							} elseif ($row["process"] == 'status') {
							?>
								<div class="sl-item b-warning">
									<div class="sl-content">
										<!--<div><?php echo strtoupper(substr($row["code"], 0, 3)) . sprintf("%04d", substr($row["code"], 3)); ?> status changed by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>-->
										<div><?php echo strtoupper($row["code"]) ?> status changed by <a class="text-info"><?php echo ucfirst($row["user"]); ?></a>.</div>
										<div class="sl-date text-muted"><?php echo strtoupper($row["time"]); ?></div>
									</div>
								</div>
							<?php
							} else {
							?>
								<div class="sl-item b-warn">
									<div class="sl-content">
										<div><a class="text-info">Something has been done by <?php echo ucfirst($row["user"]); ?></a>.</div>
										<div class="sl-date text-muted"><?php echo strtoupper($row["time"]); ?></div>
									</div>
								</div>
					<?php
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- ############ Sidebar End-->




	<!-- ############ Recent Login Side Popup Start-->

	<div class="modal fade inactive" id="login-log" data-backdrop="false">
		<div class="modal-right w-xxl dark-white b-l">
			<div class="row-col">
				<a data-dismiss="modal" class="pull-right text-muted text-lg p-a-sm m-r-sm">&times;</a>
				<div class="p-a b-b">
					<span class="h5">Last 25 Login List</span>
				</div>
				<div class="row-row light">
					<div class="row-body scrollable hover">
						<div class="row-inner">
							<div class="p-a-md">

								<?php
								$username = $_SESSION['username'];
								$sql = "select * from login_log where username='$username' ORDER BY `id` DESC LIMIT 25";

								$result = mysqli_query($conn, $sql);
								if (mysqli_num_rows($result) > 0) {
									while ($row = mysqli_fetch_assoc($result)) {
								?>

										<div class="m-b">

											<?php
											if ($row["status"] == 'success') {
											?>
												<a class="pull-left w-50 m-r-sm">
													<button class="btn btn-sm btn-icon success rounded"><i class="ion-thumbsup"></i></button>
												</a>
												<div class="clear">
													<div class="p-a p-y-sm dark-white inline r">
														<?php echo $row["location"] . " [" . $row["ip"] . "] - Successfull"; ?>
													</div>
												<?php
											} else {
												?>
													<a class="pull-left w-50 m-r-sm">
														<button class="btn btn-sm btn-icon danger rounded"><i class="ion-thumbsdown"></i></button>
													</a>
													<div class="clear">
														<div class="p-a p-y-sm dark-white inline r">
															<?php echo $row["location"] . " [" . $row["ip"] . "] - Failed"; ?>
														</div>
													<?php
												}
													?>
													<div class="text-muted text-xs m-t-xs"><i class="fa fa-ok text-success"></i><?php echo strtoupper($row["time"]); ?></div>
													</div>
												</div>

										<?php
									}
								}
										?>

										</div>
							</div>
						</div>
					</div>
					<div class="p-a b-t">
						Listed above are logins with username (<?php echo $username; ?>)
					</div>
				</div>
			</div>
		</div>

		<!-- ############ Recent Login Side Popup End-->
		<!-- ############ PAGE END-->
	</div>
</div>
<!-- / -->

<div class="app-body mobile-content">
	<div style="background-color: #a3cfe5;" class="row-col warning">
		<div class="row-cell">
			<div class="text-center col-sm-6 offset-sm-3 p-y-lg">
				<img align="center" src="<?php echo BASEURL; ?>/images/logo.png">
				<h1 class="display-4 m-y-lg">WELCOME</h1>
				<h2 class="display-5 m-y-lg">To Our Admin Panel.</h2>
				<p class="m-y text-muted h4">
					for any related queries contact:
					<span>info@gulfitinnovations.com | +971 506 989 487</span>
				</p>
			</div>
		</div>
	</div>
</div>


<?php include "includes/footer.php"; ?>