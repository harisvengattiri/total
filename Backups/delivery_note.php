<?php include "../includes/menu.php"; ?>
<?php require_once "../database.php"; ?>

<div class="app-body">
  <div class="padding">
    <div class="row">
      <div class="col-md-10">
      <?php 
            $status = getStatusFromUrl();
            if($status) {
                displaySubmissionStatus($status);
            }
        ?>
        <div class="box">
          <div class="box-header">
            <h2>Add New Delivery Note</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body">
<style>
  .form-group {
    margin-bottom: 8px;
  }
</style>
          <?php if (!isset($_POST['submit_orders'])) { ?>
            <form role="form" action="<?php echo BASEURL; ?>/add/delivery_note" method="post">
                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <select name="customer" id="customer4order" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                      <?php
                      $sql = "SELECT name,id FROM customers where type='Company' order by name";
                      $result = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($result) > 0) {
                      ?><option value=""> </option><?php
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                          <option value="<?php echo $row["id"]; ?>">[CST-<?php echo $row["id"]?>] <?php echo $row["name"] ?></option>
                      <?php } } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="type" align="" class="col-sm-2 form-control-label">Undelivered Orders</label>
                    <div class="col-sm-5">
                        <select name="jw[]" id="undeliveredOrders" class="form-control select2-multiple" multiple data-ui-jp="select2"
                        data-ui-options="{theme: 'bootstrap'}"></select>
                    </div>
                </div>
                  <div class="form-group row m-t-md">
                    <div align="center" class="col-sm-offset-2 col-sm-12">
                      <button name="submit_orders" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Check for delivery</button>
                    </div>
                  </div>
            </form>
            <?php
            } if (isset($_POST['submit_orders'])) {
              $customer = $_POST['customer'];
              $customer_name = getContactNameFromId($customer);
              $jws = $_POST['jw'];
              $jws_string = implode(",",$jws);
            ?>
            <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
                <input type="hidden" name="controller" value="deliveryNotes">
                <input type="hidden" name="token" value="<?php echo rand(1000, 9999) . date('Ymdhisa'); ?>">

                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <input type="hidden" name="customer" value="<?php echo $customer;?>">
                    <input class="form-control" type="text" value="<?php echo $customer_name;?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="type" align="" class="col-sm-2 form-control-label">Undelivered Orders</label>
                    <div class="col-sm-5">
                      <input class="form-control" type="text" name="jws" value="<?php echo $jws_string;?>" readonly>
                    </div>
                </div>

                    <div class="form-group row">
                      <label for="date" align="left" class="col-sm-2 form-control-label">Date</label>
                      <div class="col-sm-5">
                        <?php
                        $today = date('d/m/Y');
                        ?>
                        <input type="text" name="date" value="<?php echo $today; ?>" id="date" placeholder="Production Date" class="form-control has-value" data-ui-jp="datetimepicker" data-ui-options="{
                            format: 'DD/MM/YYYY',
                            icons: {
                            time: 'fa fa-clock-o',
                            date: 'fa fa-calendar',
                            up: 'fa fa-chevron-up',
                            down: 'fa fa-chevron-down',
                            previous: 'fa fa-chevron-left',
                            next: 'fa fa-chevron-right',
                            today: 'fa fa-screenshot',
                            clear: 'fa fa-trash',
                            close: 'fa fa-remove'
                            }
                        }">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label align="left" for="type" class="col-sm-2 form-control-label">Attention</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="attention">
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                      <label align="left" for="type" class="col-sm-2 form-control-label">LPO No</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="lpo">
                        </div>
                    </div> -->

                    <div class="form-group row">
                      <label for="type" class="col-sm-2 form-control-label">Transportation</label>
                      <div class="col-sm-5">
                        <input class="form-control" type="number" name="transportation" step="any" value="0">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="type" class="col-sm-2 form-control-label">Vehicle</label>
                      <div class="col-sm-5">
                        <select class="form-control" name="vehicle">
                        <?php
                        $sql = "SELECT name,id FROM vehicles";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                          echo '<option value="">Select Vehicle</option>';
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                          <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"] ?></option>
                        <?php } } ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label align="center" class="col-sm-2 form-control-label"><b>JW Number</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Item</b></label>
                      <label align="center" class="col-sm-1 form-control-label"><b>Order</b></label>
                      <label align="center" class="col-sm-1 form-control-label"><b>Balance</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Quantity</b></label>
                    </div>
                    <?php
                      foreach($jws as $jw) {
                        $order = getOrderFromJW($jw);
                        $order_items = getOrderItemDetails($order);
                        foreach($order_items as $order_item) {
                          $item = $order_item['item'];
                          $item_details = getItemDetails($item);
                          $order_balance = getItemDeliveryBalance($order,$item);
                    ?>
                    <div class="form-group row">
                        <div class="col-sm-2">
                          <input type="hidden" name="order[]" value="<?php echo $order;?>">
                          <input type="text" class="form-control" name="jw[]" value="<?php echo $jw;?>" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" value="<?php echo $item_details['name'];?>" readonly>
                          <input type="hidden" name="item[]" value="<?php echo $order_item['item'];?>" readonly>
                        </div>
                        <div class="col-sm-1">
                          <input type="text" class="form-control" value="<?php echo $order_item['quantity'];?>" readonly>
                        </div>
                        <div class="col-sm-1">
                          <input type="text" class="form-control order-balance" value="<?php echo $order_balance;?>" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" min="1" step="any" class="form-control quantity-input" name="quantity[]" value="0">
                        </div>
                    </div>
                    <?php } } ?>

                    <div class="form-group row m-t-md">
                      <div align="center" class="col-sm-offset-2 col-sm-12">
                        <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                        <button name="submit_add_deliveryNote" type="submit" class="btn btn-sm btn-outline rounded b-success text-success"
                        onclick="return validateQuantities()">Save</button>
                      </div>
                    </div>
              </form>
              <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>

<script>
    function validateQuantities() {
        var quantities = document.querySelectorAll('.quantity-input');
        var balances = document.querySelectorAll('.order-balance');
        
        for (var i = 0; i < quantities.length; i++) {
            var quantity = parseFloat(quantities[i].value);
            var balance = parseFloat(balances[i].value);
            
            if (quantity > balance) {
                alert('Entered quantity for delivery item' + (i+1) + ' is greater than the available order.');
                return false;
            }
        }
        return true;
    }
</script>

<script type="text/javascript">
 $(document).ready(function() {
  $("#customer4order").change(function() {
    var cust_id = $(this).val();
    $("#undeliveredOrders").val(null).trigger('change');
    if(cust_id != "") {
      $.ajax({
        url: "<?php echo BASEURL;?>/loads/get_orders",
        data:{c_id:cust_id},
        type:'POST',
        success:function(response) {
          var resp = $.trim(response);
          $("#undeliveredOrders").html(resp);
        }
      });
    }
  });
});
</script>

<?php include "../includes/footer.php"; ?>
