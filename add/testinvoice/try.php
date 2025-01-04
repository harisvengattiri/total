<?php include_once("config.php");?>
<head>
  	<!-- JS -->
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.js"></script>
	<script src="//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script src="js/bootstrap.datetime.js"></script>
	<script src="js/bootstrap.password.js"></script>
	<script src="js/scripts.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" href="bootstrap.min.css">

</head>

<body>
<?php


// populate product dropdown for invoice creation
function popProductsList() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM products ORDER BY product_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		echo '<select class="form-control item-select">';
		while($row = $results->fetch_assoc()) {

		    print '<option value="'.$row['product_price'].'">'.$row["product_name"].' - '.$row["product_desc"].'</option>';
		}
		echo '</select>';

	} else {

		echo "<p>There are no products, please add a product.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}
?>
<table class="table table-bordered" id="invoice_table">
				<thead>
					<tr>
						<th width="500">
							<h4><a href="#" class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Item</h4>
						</th>
						<th>
							<h4>Qty</h4>
						</th>
						<th>
							<h4>Price</h4>
						</th>
						<th width="300">
							<h4>Discount</h4>
						</th>
						<th>
							<h4>Sub Total</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div class="form-group form-group-sm  no-margin-bottom">
								<a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
								<input type="text" class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter item title and / or description">
								<p class="item-select">or <a href="#">select an item</a></p>
							</div>
						</td>
						<td class="text-right">
							<div class="form-group form-group-sm no-margin-bottom">
								<input type="text" class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="1">
							</div>
						</td>
						<td class="text-right">
							<div class="input-group input-group-sm  no-margin-bottom">
								<span class="input-group-addon"><?php echo CURRENCY ?></span>
								<input type="text" class="form-control calculate invoice_product_price required" name="invoice_product_price[]" aria-describedby="sizing-addon1" placeholder="0.00">
							</div>
						</td>
						<td class="text-right">
							<div class="form-group form-group-sm  no-margin-bottom">
								<input type="text" class="form-control calculate" name="invoice_product_discount[]" placeholder="Enter % or value (ex: 10% or 10.50)">
							</div>
						</td>
						<td class="text-right">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><?php echo CURRENCY ?></span>
								<input type="text" class="form-control calculate-sub" name="invoice_product_sub[]" id="invoice_product_sub" value="0.00" aria-describedby="sizing-addon1" disabled>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<div id="invoice_totals" class="padding-right row text-right">
				<div class="col-xs-6">
					<div class="input-group form-group-sm textarea no-margin-bottom">
						<textarea class-"form-control" name="invoice_notes" placeholder="Please enter any order notes here."></textarea>
					</div>
				</div>
				<div class="col-xs-6 no-padding-right">
					<div class="row">
						<div class="col-xs-4 col-xs-offset-5">
							<strong>Sub Total:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?><span class="invoice-sub-total">0.00</span>
							<input type="hidden" name="invoice_subtotal" id="invoice_subtotal">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-5">
							<strong>Discount:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?><span class="invoice-discount">0.00</span>
							<input type="hidden" name="invoice_discount" id="invoice_discount">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-5">
							<strong class="shipping">Shipping:</strong>
						</div>
						<div class="col-xs-3">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><?php echo CURRENCY ?></span>
								<input type="text" class="form-control calculate shipping" name="invoice_shipping" aria-describedby="sizing-addon1" placeholder="0.00">
							</div>
						</div>
					</div>
					<?php if (ENABLE_VAT == true) { ?>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-5">
							<strong>TAX/VAT:</strong><br>Remove TAX/VAT <input type="checkbox" class="remove_vat">
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?><span class="invoice-vat" data-enable-vat="<?php echo ENABLE_VAT ?>" data-vat-rate="<?php echo VAT_RATE ?>" data-vat-method="<?php echo VAT_INCLUDED ?>">0.00</span>
							<input type="hidden" name="invoice_vat" id="invoice_vat">
						</div>
					</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-4 col-xs-offset-5">
							<strong>Total:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?><span class="invoice-total">0.00</span>
							<input type="hidden" name="invoice_total" id="invoice_total">
						</div>
					</div>
				</div>

			</div>



		<div id="insert" class="modal fade">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Select an item</h4>
		      </div>
		      
		      <div class="modal-footer">
		        <button type="button" data-dismiss="modal" class="btn btn-primary" id="selected">Add</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
		      </div>
                         <div class="modal-body">
				<?php popProductsList(); ?>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->