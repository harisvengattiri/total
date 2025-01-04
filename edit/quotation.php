<?php include "../includes/menu.php"; ?>
<?php require_once("../database.php");?>
<?php
  if ($_GET) { $quotation = $_GET["id"];}
    $qtn_details = getQuotationDetails($quotation);
    $quotation = $qtn_details['id'];
?>
<div class="app-body">
    <style>
        .form-group {
            margin-bottom: 8px;
        }
    </style>

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
                        <h2>Edit Quotation: QTN|<?php echo $quotation; ?></h2>
                    </div>
                    <div class="box-divider m-a-0"></div>
                    <div class="box-body">


                        <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
                            <input type="hidden" name="controller" value="quotations">
                            <input name="id" type="text" value="<?php echo $quotation; ?>" hidden="hidden">
                            <div class="form-group row">
                                <label align="" for="name" class="col-sm-2 form-control-label">Customer</label>
                                <div class="col-sm-4">
                                    <select name="customer" id="customer" class="form-control">
                                        <?php
                                        $customer = $qtn_details['customer'];
                                        $sql = "SELECT name,id FROM customers where type='Company' order by name";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = ($row['id'] == $customer) ? "selected='selected'" : '';
                                        ?>
                                                <option <?php echo $selected; ?> value="<?php echo $row["id"]; ?>">[CST-<?php echo $row["id"];?>] <?php echo $row["name"];?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            


                                    <div class="form-group row">
                                        <label for="date" align="left" class="col-sm-2 form-control-label">Quotation Date</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="date" value="<?php echo $qtn_details['date']; ?>" id="date" placeholder="Production Date" class="form-control has-value" data-ui-jp="datetimepicker" data-ui-options="{
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
                                    <label align="" for="type" class="col-sm-2 form-control-label">Attention</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" type="text" value="<?php echo $qtn_details['attention']; ?>" name="attention">
                                        </div>
                                    </div>

                                        <div class="form-group row">
                                            <label for="type" class="col-sm-2 form-control-label">Transportation</label>
                                            <div class="col-sm-4">
                                                <input class="form-control" type="number" name="transportation" step="any" value="<?php echo $qtn_details['transportation']; ?>">
                                            </div>
                                        </div>


                                    <?php

                                    $qtn_items = getQuotationItemDetails($quotation);
                                        $count = 0;
                                        foreach ($qtn_items as $fetch) {
                                            $count++;
                                            $item = $fetch['item'];
                                            $quantity = $fetch['quantity'];
                                            $quantity = ($quantity != NULL) ? $quantity : 0;
                                            $unit = $fetch['price'];
                                            $total = $fetch['total'];
                                    ?>
                                            <?php if ($count == 1) { ?>
                                                <div class="form-group row col-md-12" style="margin-bottom:3px;margin-left:-16px;">
                                                    <div class="col-sm-7" style="margin: 2px;"></div>
                                                    <div class="box-tools">
                                                        <a href="javascript:void(0);" class="btn btn-info btn-sm" id="btnAddMoreSpecification" data-original-title="Add More">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="form-group row col-md-12" style="margin-bottom:3px;">
                                                <div class="col-sm-3">
                                                    <select name="item[]" id="item_<?php echo $count;?>" class="form-control" placeholder="Item">
                                                        <?php
                                                        $sql = "SELECT name,id FROM items ORDER BY id";
                                                        $result = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $selected = ($row['id'] == $item) ? "selected='selected'" : '';
                                                        ?>
                                                            <option <?php echo $selected; ?> value="<?php echo $row["id"]; ?>"><?php echo $row["name"] ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" min="1" step="any" class="form-control" value="<?php echo $quantity; ?>" name="quantity[]" id="qnt_<?php echo $count;?>" placeholder="Quantity">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" min="1" step="any" class="form-control" value="<?php echo $unit; ?>" name="unit[]" placeholder="Unit Price">
                                                </div>
                                                <?php
                                                if ($count == 1) {
                                                ?>
                                                    <div class="box-tools">
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btnRemoveMoreSpecification" data-original-title="Add More">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                <?php } else {
                                                ?>
                                                    <div class="box-tools">
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btnRemoveMoreSpecification" data-original-title="Add More">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                    <?php } ?>

                                    <div id="divSpecificatiion">

                                    </div>

                                    <div class="form-group row col-md-12">
                                        <label for="pterms" class="col-sm-2 form-control-label">Terms & Conditions</label>
                                        <div class="col-sm-10">
                                            <textarea name="terms" data-ui-jp="summernote">
                                                <?php echo $qtn_details['terms']; ?>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row m-t-md">
                                        <div align="right" class="col-sm-offset-2 col-sm-12">
                                            <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                                            <button name="submit_edit_quotation" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ############ PAGE END-->

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

        var currentRow = <?php echo $count;?>

        let quotationItemRow = currentRow+1;

        $('#btnAddMoreSpecification').click(function() {

            const itemRow = document.createElement('div');
            itemRow.setAttribute('class', 'form-group row col-md-12');
            itemRow.style.marginBottom = '3px';

            var qnoInnerDiv = `
                <div class="col-sm-3">
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
                <div class="col-sm-2"><input type="number" min="1" step="any" class="form-control" name="quantity[]" id="qnt_${quotationItemRow}" placeholder="Quantity"></div>
                <div class="col-sm-2"><input type="number" min="1" step="any" class="form-control" name="unit[]" placeholder="Unit Price"></div>
		        <div class="box-tools">
                  <a href="javascript:void(0);"  class="btn btn-danger btn-sm btnRemoveItems" data-original-title="Remove One">
                  <i class="fa fa-times"></i></a>
                </div>`;

            if (quotationItemRow <= 25) {
                $(itemRow).append(qnoInnerDiv);
                $('#divSpecificatiion').append(itemRow);
            }
            quotationItemRow++;
            $(itemRow).on('click', '.btnRemoveItems', function() {
                $(itemRow).remove();
            });
        });
    });
</script>
<?php include "../includes/footer.php"; ?>