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
            <h2>Add New Invoice</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body">
<style>
  .form-group {
    margin-bottom: 8px;
  }
</style>
          <?php if (!isset($_POST['submit_orders'])) { ?>
            <form role="form" action="<?php echo BASEURL; ?>/add/invoice" method="post">
                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <select name="customer" id="customer4invoice" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
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
                    <label for="type" align="" class="col-sm-2 form-control-label">Good Returns</label>
                    <div class="col-sm-5">
                        <select name="returns[]" id="goodReturns" class="form-control select2-multiple" multiple data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}"></select>
                    </div>
                </div>
                  <div class="form-group row m-t-md">
                    <div align="center" class="col-sm-offset-2 col-sm-12">
                      <button name="submit_orders" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Check for Items</button>
                    </div>
                  </div>
            </form>
            <?php
            // for proper working of script in this page
            $returnsList = '0';
            } if (isset($_POST['submit_orders'])) {
              $customer = $_POST['customer'];
              $customer_name = getContactNameFromId($customer);
              $returns = $_POST['returns'];
              $returnsList = implode(",",$returns);
            ?>
            <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
                <input type="hidden" name="controller" value="invoice">
                <input type="hidden" name="token" value="<?php echo rand(1000, 9999) . date('Ymdhisa'); ?>">

                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <input type="hidden" name="customer" value="<?php echo $customer;?>">
                    <input class="form-control" type="text" value="<?php echo $customer_name;?>" readonly>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="type" align="" class="col-sm-2 form-control-label">Goods Returns</label>
                    <div class="col-sm-5">
                      <input class="form-control" type="text" name="returns" value="<?php echo $returnsList;?>" readonly>
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
                      <label align="left" for="type" class="col-sm-2 form-control-label">Note</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="attention">
                        </div>
                    </div>

                    <div class="form-group row">
                      <label align="center" class="col-sm-3 form-control-label"><b>Item</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>GR Number</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>JW Numbar</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Delivered OK Quantity</b></label>
                      <label align="center" class="col-sm-2 form-control-label"><b>Approx Price</b></label>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-3">
                            <select class="form-control" id="rtnItemID_0">
                            <?php                                
                            $sqlItem1="SELECT gi.id AS giId,itm.name AS itemName,gi.return_id AS returnID,gi.order_remark,gi.delivery_remark
                                    FROM goods_return_item gi
                                    INNER JOIN items itm ON gi.item=itm.id
                                    WHERE gi.status=1 AND gi.return_id IN ($returnsList)";
                            $resultItem1=$conn->query($sqlItem1);
                            ?> <option value="">Select Item</option> <?php
                            if($resultItem1->num_rows > 0) {
                            while($rowItem1=$resultItem1->fetch_assoc()) {
                              $ord_remarkId = $rowItem1['order_remark'];
                              $del_remarkId = $rowItem1['delivery_remark'];
                              $order_remark = getRemarkOfOrderItem($ord_remarkId);
                              $delivery_remark = getRemarkOfdeliveryItem($del_remarkId);
                            ?>
                            <option value="<?php echo $rowItem1['giId'];?>" title="Order Remark: <?php echo $order_remark; ?> | Delivery Remark: <?php echo $delivery_remark; ?>">
                              <?php echo $rowItem1['itemName'];?> [<?php echo $order_remark;?> --> <?php echo $delivery_remark;?>]
                            </option>
                            <?php  } } ?>                    
                            </select>
                        </div>
                        <div class="col-sm-2">
                          <input type="hidden" name="item[]" id="Item_0" readonly>
                          <input type="text" class="form-control" name="gr[]" id="ItemGR_0" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" class="form-control" name="jw[]" id="ItemJW_0" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" class="form-control delivered-quantity" name="delivered_quantity[]" id="deliveredQuantity_0" readonly>
                        </div>
                        <div class="col-sm-2">
                          <input type="text" min="1" step="any" class="form-control quantity-input" name="price[]" id="price_0">
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
                        <button name="submit_add_invoice" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
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

<script type="text/javascript">
 $(document).ready(function() {
  $("#customer4invoice").change(function() {
    var cust_id = $(this).val();
    $("#goodReturns").val(null).trigger('change');
    if(cust_id != "") {
      $.ajax({
        url: "<?php echo BASEURL;?>/loads/get_uninvoiced_return",
        data:{c_id:cust_id},
        type:'POST',
        success:function(response) {
          var resp = $.trim(response);
          $("#goodReturns").html(resp);
        }
      });
    }
  });
});
</script>

<script>
$(document).ready(function() {
  $('#rtnItemID_0').on('change', function () {
    var goodsItemRow = this.id.split('_')[1];
    var grItem = $(this).val();
    getDeliveredQuantity(goodsItemRow, grItem);
  });
});

function getDeliveredQuantity(goodsItemRow, grItem) {
  if (grItem != "") {
    $.ajax({
    url: '<?php echo BASEURL;?>/loads/get_item_returnDetails',
    data: {grItem: grItem},
    type: 'POST',
    dataType: 'json',
    success: function(response) {
      var Item = response.Item;
      var JwNumber = response.JwNumber;
      var deliveredQuantity = response.deliveredQuantity;
      var returnId = response.returnId;
      var price = response.price;
      $("#Item_" + goodsItemRow).val(Item);
      $("#ItemGR_" + goodsItemRow).val(returnId);
      $("#ItemJW_" + goodsItemRow).val(JwNumber);
      $("#deliveredQuantity_" + goodsItemRow).val(deliveredQuantity);
      $("#price_" + goodsItemRow).val(price);
    },
    error: function(xhr, status, error) {
      console.error("Error: " + error);
    }
    });
  }
}

$(document).ready(function() {
    let goodsItemRow = 1;
    const MAX_GOODS_RETURN_ROWS = 120;

    $('#btnAddMore').click(function () {
        const goodsRow = document.createElement('div');
        goodsRow.setAttribute('class', 'form-group row');

        var goodsReturnInnerDiv = `
            <div class="col-sm-3">
                <select class="form-control" id="rtnItemID_${goodsItemRow}">
                <?php                                
                    $sqlItem1="SELECT gi.id AS giId,itm.name AS itemName,gi.return_id AS returnID,gi.order_remark,gi.delivery_remark
                            FROM goods_return_item gi
                            INNER JOIN items itm ON gi.item=itm.id
                            WHERE gi.status=1 AND gi.return_id IN ($returnsList)";
                    $resultItem1=$conn->query($sqlItem1);
                    ?> <option value="">Select Item</option> <?php
                    if($resultItem1->num_rows > 0) {
                    while($rowItem1=$resultItem1->fetch_assoc()) {
                      $ord_remarkId = $rowItem1['order_remark'];
                      $del_remarkId = $rowItem1['delivery_remark'];
                      $order_remark = getRemarkOfOrderItem($ord_remarkId);
                      $delivery_remark = getRemarkOfdeliveryItem($del_remarkId);
                    ?>
                    <option value="<?php echo $rowItem1['giId'];?>" title="Order Remark: <?php echo $order_remark; ?> | Delivery Remark: <?php echo $delivery_remark; ?>">
                     <?php echo $rowItem1['itemName'];?> [<?php echo $order_remark;?> --> <?php echo $delivery_remark;?>]
                    </option>
                <?php  } } ?>                      
                </select>
            </div>
            <div class="col-sm-2">
                <input type="hidden" name="item[]" id="Item_${goodsItemRow}" readonly>
                <input type="text" class="form-control" name="gr[]" id="ItemGR_${goodsItemRow}" readonly>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control" name="jw[]" id="ItemJW_${goodsItemRow}" readonly>
            </div>
            <div class="col-sm-2">
                <input type="text" class="form-control delivered-quantity" name="delivered_quantity[]" id="deliveredQuantity_${goodsItemRow}" readonly>
            </div>
            <div class="col-sm-2">
                <input type="text" min="1" step="any" class="form-control quantity-input" name="price[]" id="price_${goodsItemRow}">
            </div>
            <div class="box-tools">
                <a href="javascript:void(0);" class="btn btn-danger btn-sm btnRemoveDebits" data-original-title="Remove"><i class="fa fa-times"></i></a>
            </div>
        `;
        if(goodsItemRow <= MAX_GOODS_RETURN_ROWS) {

            $(goodsRow).append(goodsReturnInnerDiv);
            $('#divAttach').append(goodsRow);

            $(goodsRow).on('change', '[id^="rtnItemID_"]', function() {
              var goodsItemRow = this.id.split('_')[1];
              var grItem = $(this).val();
                getDeliveredQuantity(goodsItemRow, grItem);
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
