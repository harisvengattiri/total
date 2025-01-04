<?php include "../includes/menu.php"; ?>

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
            <h2>Add New Quotation</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body">
<style>
  .form-group {
    margin-bottom: 8px;
  }
</style>
            <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
                <input type="hidden" name="controller" value="quotations">
                <div class="form-group row">
                  <label for="name" class="col-sm-2 form-control-label">Customer</label>
                  <div class="col-sm-5">
                    <select name="customer" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                      <?php
                      $sql = "SELECT name,id FROM customers where type='Company' order by name";
                      $result = mysqli_query($conn, $sql);
                      if (mysqli_num_rows($result) > 0) {
                      ?><option value=""> </option><?php
                                      while ($row = mysqli_fetch_assoc($result)) {
                                      ?>
                          <option value="<?php echo $row["id"]; ?>">[CST-<?php echo $row["id"]?>] <?php echo $row["name"] ?></option>
                      <?php
                                      }
                                    }
                      ?>
                    </select>
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

                    <div class="form-group row">
                      <label for="type" class="col-sm-2 form-control-label">Transportation</label>
                      <div class="col-sm-5">
                        <input class="form-control" type="number" name="transportation" step="any" value="0">
                      </div>
                    </div>


                    <div class="form-group row">
                      <input type="hidden" id="itemWeight_0">
                      <div class="col-sm-4">
                        <select name="item[]" id="item_0" class="form-control" placeholder="Item" required>
                          <option value="">Select Item</option>
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
                        <input type="number" min="1" step="any" class="form-control" name="quantity[]" id="qnt_0" placeholder="Quantity">
                      </div>
                      <div class="col-sm-2">
                        <input type="number" min="1" step="any" class="form-control" name="unit[]" placeholder="Unit Price">
                      </div>
                      <div class="box-tools">
                        <a href="javascript:void(0);" class="btn btn-info btn-sm" id="btnAddMoreSpecification" data-original-title="Add More">
                          <i class="fa fa-plus"></i>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div id="divSpecificatiion1">

                      </div>
                    </div>

                    <div class="form-group row col-md-12">
                      <label for="pterms" class="col-sm-2 form-control-label">Terms & Conditions</label>
                      <div class="col-sm-7">
                        <textarea name="terms" data-ui-jp="summernote">
                Terms &amp; Conditions&nbsp;
                <ol>
                  <li>Price Validity : 5 Days&nbsp;</li>
                  <li>Payment Terms : CDC / PDC Subject to Approval&nbsp;</li>
                  <li>Delivery Terms : Delivery at Site</li>
                  <li>The Units price quoted are does not included the VAT or any other types of taxes <br/>imposed by our government.</li>
                </ol>
              </textarea>
                      </div>
                    </div>

                    <div class="form-group row m-t-md">
                      <div align="right" class="col-sm-offset-2 col-sm-12">
                        <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                        <button name="submit_add_quotation" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
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


<script>
  $(document).ready(function(event) {
    let quotationItemRow = 1;

    $('#btnAddMoreSpecification').click(function() {

      const itemRow = document.createElement('div');
      itemRow.setAttribute('class', 'form-group row');

      var qnoInnerDiv = `
                <div class="col-sm-4">
                <select name="item[]" id="item_${quotationItemRow}" class="form-control" placeholder="Item" required>
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
                <div class="col-sm-2"><input type="number" min="1" step="any" class="form-control" name="quantity[]" id="qnt_${quotationItemRow}" placeholder="Quantity"><input type="hidden" id="itemWeight_${quotationItemRow}"></div>
                <div class="col-sm-2"><input type="number" min="1" step="any" class="form-control" name="unit[]" placeholder="Unit Price"></div>
		            <div class="box-tools">
                  <a href="javascript:void(0);"  class="btn btn-danger btn-sm btnRemoveItems" data-original-title="Remove One">
                  <i class="fa fa-times"></i></a>
                </div>`;

      if (quotationItemRow <= 25) {
        $(itemRow).append(qnoInnerDiv);
        $('#divSpecificatiion1').append(itemRow);
      }

      quotationItemRow++;
      $(itemRow).on('click', '.btnRemoveItems', function() {
        $(itemRow).remove();
      });
    });

  });
</script>

<?php include "../includes/footer.php"; ?>
