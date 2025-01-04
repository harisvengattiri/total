<?php require_once "includes/menu.php"; ?>
<?php require_once "database.php"; ?>
<?php 
    $status = getStatusFromUrl();
?>
<div class="app-body">
    <div class="padding">

	<?php if($status=="success") { ?>
	<p><a class="list-group-item b-l-success">
          <span class="pull-right text-success"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label success pos-rlt m-r-xs">
		  <b class="arrow right b-success pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-success">Your Submission was Successfull!</span>
    </a></p>
	<?php } else if($status=="failed") { ?>
	<p><a class="list-group-item b-l-danger">
          <span class="pull-right text-danger"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label danger pos-rlt m-r-xs">
		  <b class="arrow right b-danger pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-danger">Your Submission was Failed!</span>
    </a></p>
	<?php } ?>

        <div class="box">
            <div class="box-header">
                <span style="float: left;">
                    <h2>Products</h2>
                </span>
                <span style="float: right;"><a href="<?php echo BASEURL; ?>/add/item"><button class="btn btn-outline btn-sm rounded b-primary text-primary"><i class="fa fa-plus"></i> Add New</a></button>&nbsp;
                    <?php
                    if (isset($_GET['view'])) {
                    ?>
                        <a href="<?php echo BASEURL; ?>/items"><button class="btn btn-outline btn-sm rounded b-success text-success"><i class="fa fa-list"></i> View Recent</a></button>
                    <?php
                    } else {
                    ?>
                        <a href="<?php echo BASEURL; ?>/items?view=all"><button class="btn btn-outline btn-sm rounded b-success text-success"><i class="fa fa-list"></i> View All</a></button>
                    <?php
                    } ?>
                </span>
            </div><br />
            <div class="box-body">
                <span style="float: left;"></span>
                <span style="float: right;">Search: <input id="filter" type="text" class="form-control form-control-sm input-sm w-auto inline m-r" /></span>
            </div>
            <div>
                <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
                    <thead>
                        <tr>
                            <th data-toggle="true">
                                Product Code
                            </th>
                            <th>
                                Item Name
                            </th>
                            <th>
                                Approx Value
                            </th>
                            <th>
                                Rough Cast Weight
                            </th>
                            <th>
                                Scrap Weight
                            </th>
                            <th>
                                Finished Good Weight
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $itemsList = getItemsList();
                            foreach ($itemsList as $row) {
                        ?>
                                <tr>
                                    <td>PRD <?php echo sprintf("%04d", $row["id"]); ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["approx_price"]; ?></td>
                                    <td><?php echo $row["cast_weight"]; ?></td>
                                    <td><?php echo $row["scrap_weight"]; ?></td>
                                    <td><?php echo $row["good_weight"]; ?></td>
                                    <td>
                                        <a href="<?php echo BASEURL; ?>/edit/item?id=<?php echo $row["id"]; ?>"><button class="btn btn-xs btn-icon info"><i class="fa fa-pencil"></i></button></a>
                                        <?php if ($_SESSION['role'] == 'admin') { ?>
                                            <a href="<?php echo BASEURL; ?>/controller?controller=items&submit_delete_item=delete&id=<?php echo $row["id"];?>" 
                                            onclick="return confirm('Are you sure?')"><button class="btn btn-xs btn-icon danger"><i class="fa fa-trash"></i></button></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        ?>
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
