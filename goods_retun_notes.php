<?php require_once "includes/menu.php"; ?>
<?php require_once "database.php"; ?>
<div class="app-body">
    <!-- ############ PAGE START-->
    <div class="padding">
        <div class="box">
        <?php 
            $status = getStatusFromUrl();
            if($status) {
                displaySubmissionStatus($status);
            }
        ?>
            <div class="box-header">
                <span style="float: left;">
                    <h2>Goods Return Notes</h2>
                </span>
                <span style="float: right;">
                    <a href="<?php echo BASEURL; ?>/add/goods_return_note"><button class="btn btn-outline btn-sm rounded b-primary text-primary"><i class="fa fa-plus"></i> Add New Goods Return Note</a></button>
                    &nbsp;
                </span>
            </div><br />
            <div class="box-body">

                <form role="form" action="<?php echo BASEURL; ?>/goods_retun_notes" method="POST">
                    <div class="form-group row">
                        <label for="Quantity" class="col-sm-1 form-control-label">From</label>
                        <div class="col-sm-3">
                            <input type="text" name="fdate" id="date" placeholder="From Date" class="form-control has-value" data-ui-jp="datetimepicker" data-ui-options="{
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
                  }" required>
                        </div>
                        <label align="right" for="Quantity" class="col-sm-1 form-control-label">To</label>
                        <div class="col-sm-3">
                            <input type="text" name="tdate" id="date" placeholder="To Date" class="form-control has-value" data-ui-jp="datetimepicker" data-ui-options="{
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
                  }" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Customer" class="col-sm-1 form-control-label">Customer</label>
                        <div class="col-sm-3">
                            <select name="customer" class="form-control select2" data-ui-jp="select2" data-ui-options="{theme: 'bootstrap'}">
                                <?php
                                $sql = "SELECT name,id FROM customers where type='Company' order by name";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                ?><option value=""> </option>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?php echo $row["id"]; ?>">[CST-<?php echo $row["id"] ?>] <?php echo $row["name"]; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <button name="submit" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Search</button>
                        </div>
                    </div>
                </form>
                <?php
                $filters = getSearchFilters();
                    $period_sql = $filters['period_sql'];
                    $cust_sql = $filters['cust_sql'];
                    $mode = $filters['mode'];
                    $show_date = $filters['show_date'];
                ?>
                <h4 style="padding: 15px 0;color: green;float:left;"><span style="font-weight:600;">Mode:</span> <?php echo $mode . $show_date; ?></h4>

                <span style="float: left;"></span>
                <span style="float: right;">Filter: <input id="filter" type="text" class="form-control form-control-sm input-sm w-auto inline m-r" /></span>
            </div>
            <div>
                <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
                    <thead>
                        <tr>
                            <th>
                                Goods Return No
                            </th>
                            <th>
                                Delivery
                            </th>
                            <th>
                                Customer
                            </th>
                            <th>
                                Date
                            </th>
                            <th>
                                Invoiced
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['fdate'])) {
                            $sql = "SELECT * FROM goods_return_note $period_sql $cust_sql ORDER BY id ASC LIMIT 0,1000";
                        } else {
                            $sql = "SELECT * FROM goods_return_note ORDER BY id DESC LIMIT 0,100";
                        }
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $returnId = $row["id"];
                                $custId = $row["customer"];
                                $customer = getContactNameFromId($custId);
                                $delivery = getDeliveryFromReturn($returnId);
                        ?>
                                <tr>
                                    <td>GR|<?php echo sprintf("%06d", $returnId); ?></td>
                                    <td>DN|<?php echo sprintf("%05d", $delivery); ?></td>
                                    <td><?php echo $customer; ?></td>
                                    <td><?php echo $row["date"]; ?></td>
                                    <td><?php echo checkInvoiced($returnId,'goodsReturn'); ?></td>
                                    <td>
                                        <a target="_blank" href="<?php echo CDNURL; ?>/goods_return_note?id=<?php echo $returnId;?>"><button class="btn btn-xs btn-icon success"><i class="fa fa-folder-open"></i></button></a>
                                        <!-- <a href="<?php // echo BASEURL; ?>/edit/delivery_note?id=<?php // echo $row["id"]; ?>"><button class="btn btn-xs btn-icon info">
                                            <i class="fa fa-pencil"></i></button></a> -->
                                        <a href="<?php echo BASEURL; ?>/controller?controller=returnNotes&submit_delete_returnNote=delete&id=<?php echo $returnId;?>" onclick="return confirm('Are you sure?')"><button class="btn btn-xs btn-icon danger"><i class="fa fa-trash"></i></button></a>
                                    </td>
                                </tr>
                        <?php } } ?>
                    </tbody>
                    <tfoot class="hide-if-no-paging">
                        <tr>
                            <td colspan="5" class="text-center">
                                <ul class="pagination"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php include "includes/footer.php"; ?>
