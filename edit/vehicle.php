<?php include "../includes/menu.php";?>
<?php require_once "../database.php";?>

<div class="app-body">
<?php
if ($_GET) 
{
$vehicle = $_GET["id"];
$veh_details = getVehicleDetails($vehicle);
}
?>

<div class="padding">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <h2>Edit Vehicle</h2>
          </div>
        <div class="box-divider m-a-0"></div>
        <div class="box-body">
          <form role="form" action="<?php echo BASEURL;?>/controller" method="post">
                <input name="id"  type="text" value="<?php echo $vehicle;?>" hidden="hidden">
                <input type="hidden" name="controller" value="vehicles">
            <div class="form-group row">
              <label for="Quantity" class="col-sm-2 form-control-label">Model</label>
              <div class="col-sm-4">
                   <input type="text" class="form-control" name="name" value="<?php echo $veh_details['name'];?>" id="value" placeholder="Model">
              </div>
            </div>
            <div class="form-group row">  
              <label for="Quantity" class="col-sm-2 form-control-label">Reg No</label>
              <div class="col-sm-4">
                   <input type="text" class="form-control" name="registration" value="<?php echo $veh_details['registration'];?>" id="value" placeholder="Reg No">
              </div>
            </div>

            <div class="form-group row m-t-md">
              <div align="right" class="col-sm-offset-2 col-sm-12">
                <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                <button name="submit_edit_vehicle" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
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
  
<?php include "../includes/footer.php";?>
