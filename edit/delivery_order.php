<?php include "../includes/menu.php"; ?>
<?php include "../database.php"; ?>

<div class="app-body">
  <div class="padding">
    <div class="row">
      <div class="col-md-10">
      <?php 
        $status = getStatusFromUrl();
        if($status) {
            displaySubmissionStatus($status);
        }
        if($_GET['id']) {
            $order = $_GET['id'];
            $order_details = getOrderDetails($order);
            $customer = $order_details['customer'];
            $customer_name = getContactNameFromId($customer);
        }  
        ?>
        <div class="box">
          <div class="box-header">
            <h2>Edit Delivery Order</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body">
<style>
  .form-group {
    margin-bottom: 8px;
  }
</style>
            <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
                <input type="hidden" name="controller" value="salesOrders">
                <input type="hidden" name="id" value="<?php echo $order;?>">

                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <select name="customer" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                      <option value="<?php echo $customer;?>"><?php echo $customer_name;?></option>
                      <?php
                      $sql = "SELECT name,id FROM customers where type='Company' order by name";
                      $result = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <option value="<?php echo $row["id"]; ?>">[CST-<?php echo $row["id"]?>] <?php echo $row["name"] ?></option>
                      <?php
                          } }
                      ?>
                    </select>
                  </div>
                </div>

                    <div class="form-group row">
                      <label for="date" align="left" class="col-sm-2 form-control-label">Date</label>
                      <div class="col-sm-5">
                        <input type="text" name="date" value="<?php echo $order_details['date']; ?>" id="date" placeholder="Production Date" class="form-control has-value" data-ui-jp="datetimepicker" data-ui-options="{
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
                      <label align="left" for="type" class="col-sm-2 form-control-label">JW Number</label>
                        <div class="col-sm-5">
                            <input class="form-control" type="text" name="jw" value="<?php echo $order_details['jw']; ?>" placeholder="JW Number">
                        </div>
                    </div>

                    <?php
                        $order_items = getOrderItemDetails($order);
                        $count = 0;
                        foreach ($order_items as $fetch) {
                            $count++;
                            $item = $fetch['item'];
                                $item_details = getItemDetails($item);
                                $item_name = $item_details['name'];
                            $remarkId = $fetch['remark'];
                              $remark = getRemarkOfOrderItem($remarkId);
                            $quantity = $fetch['quantity'];
                            $quantity = ($quantity != NULL) ? $quantity : 0;
                            $unit = $fetch['price'];
                            $total = $fetch['total'];
                    ?>
                    <div class="form-group row">
                      <input type="hidden" id="itemWeight_0">
                      <div class="col-sm-4">
                        <select name="item[]" id="item_0" class="form-control" placeholder="Item" required>
                          <option value="<?php echo $item;?>"><?php echo $item_name;?></option>
                          <?php
                          $sql = "SELECT name,id FROM items ORDER BY name";
                          $result = mysqli_query($conn, $sql);
                          if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                          ?>
                              <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"] ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-sm-2">
                        <input type="number" min="1" step="any" class="form-control" name="quantity[]" id="qnt_0" value="<?php echo $quantity;?>" placeholder="Quantity">
                      </div>
                      <div class="col-sm-2">
                        <select name="remark[]" class="form-control">
                          <option value="<?php echo $remarkId;?>"><?php echo $remark;?></option>
                          <option value="1">ROUGH CAST</option>
                          <option value="2">SAMPLE</option>
                          <option value="3">REWORK</option>
                        </select>
                      </div>

                        <?php if ($count == 1) { ?>
                            <div class="box-tools">
                                <a href="javascript:void(0);" class="btn btn-info btn-sm" id="btnAddMoreSpecification" data-original-title="Add More">
                                <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="box-tools">
                                <a href="javascript:void(0);"  class="btn btn-danger btn-sm btnRemoveMoreSpecification" data-original-title="Remove One">
                                <i class="fa fa-times"></i></a>
                            </div>
                        <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="col-md-12">
                      <div id="divSpecificatiion1">

                      </div>
                    </div>

                    <div class="form-group row m-t-md">
                      <div align="right" class="col-sm-offset-2 col-sm-12">
                        <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                        <button name="submit_edit_order" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
                      </div>
                    </div>
              </form>

          </div>
        </div>
      </div>
    </div>
  </div>


</div>
</div>
<!-- / -->

<!--Script to remove row while coming directly from database-->
<script>
    $(document).on('click', '.btnRemoveMoreSpecification', function () {
        $(this).parent('div').parent('div').remove();
    });
</script>
<script>
  $(document).ready(function(event) {
    let orderItemRow = 1;

    $('#btnAddMoreSpecification').click(function() {

      const itemRow = document.createElement('div');
      itemRow.setAttribute('class', 'form-group row');

      var ordInnerDiv = `
                <div class="col-sm-4">
                <select name="item[]" id="item_${orderItemRow}" class="form-control" placeholder="Item" required>
                <option value="">Select Item</option>
                <?php
                $sql = "SELECT name,id FROM items ORDER BY name";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                ?><option value="<?php echo $row["id"]; ?>"><?php echo $row["name"] ?></option>
                <?php }
                } ?></select>
                </div>
                <div class="col-sm-2"><input type="number" min="1" step="any" class="form-control" name="quantity[]" id="qnt_${orderItemRow}" placeholder="Quantity"><input type="hidden" id="itemWeight_${orderItemRow}"></div>
                <div class="col-sm-2">
                  <select name="remark[]" class="form-control">
                    <option value="1">ROUGH CAST</option>
                    <option value="2">SAMPLE</option>
                    <option value="3">REWORK</option>
                  </select>
                </div>
		            <div class="box-tools">
                  <a href="javascript:void(0);"  class="btn btn-danger btn-sm btnRemoveItems" data-original-title="Remove One">
                  <i class="fa fa-times"></i></a>
                </div>`;

      if (orderItemRow <= 25) {
        $(itemRow).append(ordInnerDiv);
        $('#divSpecificatiion1').append(itemRow);
      }

      orderItemRow++;
      $(itemRow).on('click', '.btnRemoveItems', function() {
        $(itemRow).remove();
      });
    });

  });
</script>

<?php include "../includes/footer.php"; ?>
