<?php include "includes/menu.php";?>
<?php require_once "database.php";?>

<div class="app-body">
<div class="padding">
  <div class="box">
    <?php 
        $status = getStatusFromUrl();
        if($status) {
            displaySubmissionStatus($status);
        }
    ?>
    <div class="box-header">
	<span style="float: left;"><h2>Vehicles</h2></span> 
    <span style="float: right;">&nbsp;
<a href="<?php echo BASEURL; ?>/vehicle" ><button class="btn btn-outline btn-sm rounded b-success text-success"><i class="fa fa-list"></i> View Recent</a></button>
</span>
    </div><br/>
    <div class="box-body">
       <form role="form" action="<?php echo BASEURL;?>/controller" method="post">
            <input type="hidden" name="controller" value="vehicles">
            <div class="form-group row">
                 <label for="Quantity" class="col-sm-1 form-control-label">Model</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="name" id="value" placeholder="Model" required>
              </div>
              <label for="Quantity" class="col-sm-1 form-control-label">Reg No</label>
              <div class="col-sm-3">
                <input type="text" class="form-control" name="registration" id="value" placeholder="Reg No">
              </div>
              
              <div class="col-sm-2">
                <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                <button name="submit_add_vehicle" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
              </div>
            </div>
          </form>    
         
	<span style="float: left;"></span>
    <span style="float: right;">Search: <input id="filter" type="text" class="form-control form-control-sm input-sm w-auto inline m-r"/></span>
    </div>
    <div>
      <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" data-page-size="10">
        <thead>
          <tr>
              <th>
                 Id
              </th>
	        <th>
                Model
            </th>
	        <th>
                Reg No
            </th>
              <th>
                  Actions
              </th>
          </tr>
        </thead>
        <tbody>

		<?php
        $vehicleList = getVehicles();
            foreach ($vehicleList as $row) {
        ?>
          <tr>
            <td><?php echo $row["id"];?></td>
            <td><?php echo $row["name"];?></td>
            <td><?php echo $row["registration"];?></td>
            <td>
                <a href="<?php echo BASEURL; ?>/edit/vehicle?id=<?php echo $row["id"];?>"><button class="btn btn-xs btn-icon info"><i class="fa fa-pencil"></i></button></a>
                <a href="<?php echo BASEURL; ?>/controller?controller=vehicles&submit_delete_vehicle=delete&id=<?php echo $row["id"];?>" onclick="return confirm('Are you sure?')"><button class="btn btn-xs btn-icon danger"><i class="fa fa-trash"></i></button></a>
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
  <!-- / -->

<?php include "includes/footer.php";?>
