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
            $jws_string = 0;
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
                      <label align="center" class="col-sm-2 form-control-label"><b>Item</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>JW Number</b></label>
                      <label align="center" class="col-sm-1 form-control-label"><b>Order</b></label>
                      <label align="center" class="col-sm-1 form-control-label"><b>Balance</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Quantity</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Remarks</b></label>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2">
                            <select class="form-control" name="item[]" id="delItem_0">
                            <?php                                
                                $sqlItem1="SELECT oi.item AS itemId,itm.name AS itemName,so.jw AS jwNumber,oi.remark
                                           FROM order_item oi
                                           INNER JOIN sales_order so ON oi.order_id=so.id
                                           INNER JOIN items itm ON oi.item=itm.id
                                           WHERE so.jw IN ($jws_string)";
                                $resultItem1=$conn->query($sqlItem1);
                                ?> <option value="">Select Item</option> <?php
                                if($resultItem1->num_rows > 0) {
                                while($rowItem1=$resultItem1->fetch_assoc()) {
                                  $remarkId = $rowItem1['remark'];
                                  $remark = getRemarkOfOrderItem($remarkId);
                                ?>
                                <option value="<?php echo $rowItem1['itemId'];?>,<?php echo $rowItem1['jwNumber'];?>,<?php echo $remarkId;?>">
                                   <?php echo $rowItem1['itemName'];?> [<?php echo $remark;?>]
                                </option>
                            <?php  } } ?>                      
                            </select>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" name="jw[]" id="ItemJW_0" readonly>
                        </div>
                        <div class="col-sm-1">
                          <input type="text" class="form-control" name="order_quantity[]" id="orderQuantity_0" readonly>
                        </div>
                        <div class="col-sm-1">
                          <input type="text" class="form-control order-balance" name="order_balance[]" id="orderBalance_0" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" min="1" step="any" class="form-control quantity-input" name="quantity[]" value="0">
                        </div>
                        <div class="col-sm-2">
                            <select name="delivery_item_status[]" class="form-control">
                              <option value="1">10ᵗʰ 20ᵗʰ 30ᵗʰ OK</option>
                              <option value="2">10ᵗʰ 20ᵗʰ 30ᵗʰ OK CD</option>
                              <option value="3">REWORK OK</option>
                              <option value="4">ROUGH CAST</option>
                              <option value="5">REJECTION</option>
                            </select>
                        </div>
                        <div class="box-tools">
                            <a href="javascript:void(0);" 
                                class="btn btn-info btn-sm" id="btnAddMore" data-original-title="Add More">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div id="divAttach"></div>

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

<script>
$(document).ready(function() {
  $('#delItem_0').on('change', function () {
    var goodsItemRow = this.id.split('_')[1];
    var itemDetails = $(this).val();
    getDeliveredQuantity(goodsItemRow, itemDetails);
  });
});

function getDeliveredQuantity(goodsItemRow, itemDetails) {
  if (itemDetails != "") {
    $.ajax({
    url: '<?php echo BASEURL;?>/loads/get_item_orderDetails',
    data: {itemDetails: itemDetails},
    type: 'POST',
    dataType: 'json',
    success: function(response) {
      var JwNumber = response.JwNumber;
      var orderQuantity = response.orderQuantity;
      var orderBalance = response.orderBalance;
      $("#ItemJW_" + goodsItemRow).val(JwNumber);
      $("#orderQuantity_" + goodsItemRow).val(orderQuantity);
      $("#orderBalance_" + goodsItemRow).val(orderBalance);
    },
    error: function(xhr, status, error) {
      console.error("Error: " + error);
    }
    });
  }
}

$(document).ready(function() {
    let goodsItemRow = 1;
    const MAX_GOODS_RETURN_ROWS = 25;

    $('#btnAddMore').click(function () {
        const goodsRow = document.createElement('div');
        goodsRow.setAttribute('class', 'form-group row');

        var goodsReturnInnerDiv = `
        
          <div class="col-sm-2">
            <select class="form-control" name="item[]" id="delItem_${goodsItemRow}">
              <?php                                
                $sqlItem1="SELECT oi.item AS itemId,itm.name AS itemName,so.jw AS jwNumber,oi.remark
                          FROM order_item oi
                          INNER JOIN sales_order so ON oi.order_id=so.id
                          INNER JOIN items itm ON oi.item=itm.id
                          WHERE so.jw IN ($jws_string)";
                $resultItem1=$conn->query($sqlItem1);
                ?> <option value="">Select Item</option> <?php
                if($resultItem1->num_rows > 0) {
                while($rowItem1=$resultItem1->fetch_assoc()) {
                  $remarkId = $rowItem1['remark'];
                  $remark = getRemarkOfOrderItem($remarkId);
                ?>
                <option value="<?php echo $rowItem1['itemId'];?>,<?php echo $rowItem1['jwNumber'];?>,<?php echo $remarkId;?>">
                               <?php echo $rowItem1['itemName'];?> [<?php echo $remark;?>]
                </option>
              <?php  } } ?>                      
            </select>
          </div>
          <div class="col-sm-2">
            <input type="text" class="form-control" name="jw[]" id="ItemJW_${goodsItemRow}" readonly>
          </div>
          <div class="col-sm-1">
            <input type="text" class="form-control" name="order_quantity[]" id="orderQuantity_${goodsItemRow}" readonly>
          </div>
          <div class="col-sm-1">
            <input type="text" class="form-control order-balance" name="order_balance[]" id="orderBalance_${goodsItemRow}" readonly>
          </div>
          <div class="col-sm-2">
            <input type="text" min="1" step="any" class="form-control quantity-input" name="quantity[]" value="0">
          </div>
          <div class="col-sm-2">
              <select name="delivery_item_status[]" class="form-control">
                <option value="1">10ᵗʰ 20ᵗʰ 30ᵗʰ OK</option>
                <option value="2">10ᵗʰ 20ᵗʰ 30ᵗʰ OK CD</option>
                <option value="3">REWORK OK</option>
                <option value="4">ROUGH CAST</option>
                <option value="5">REJECTION</option>
              </select>
          </div>
          <div class="box-tools">
            <a href="javascript:void(0);" class="btn btn-danger btn-sm btnRemoveDebits" data-original-title="Remove"><i class="fa fa-times"></i></a>
          </div>
        `;
        if(goodsItemRow <= MAX_GOODS_RETURN_ROWS) {

            $(goodsRow).append(goodsReturnInnerDiv);
            $('#divAttach').append(goodsRow);

            $(goodsRow).on('change', '[id^="delItem_"]', function() {
              var goodsItemRow = this.id.split('_')[1];
              var itemDetails = $(this).val();
                getDeliveredQuantity(goodsItemRow, itemDetails);
            }); 

            goodsItemRow++;
            $(goodsRow).on('click', '.btnRemoveDebits', function () {
              $(goodsRow).remove();
            });
        }

    });
});
</script>

<?php include "../includes/footer.php"; ?>
