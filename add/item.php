<?php include "../includes/menu.php";?>
<?php 
    $status = getStatusFromUrl();
?>
<div class="app-body">
<!-- ############ PAGE START-->
<div class="padding">
  <div class="row">
    <div class="col-md-6">
	<?php if($status=="success") {?>
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
          <h2>Add New Product</h2>
          </div>
        <div class="box-divider m-a-0"></div>
        
        <div class="box-body">
          <form role="form" action="<?php echo BASEURL;?>/controller" method="post">
            <input type="hidden" name="controller" value="items">
            <div class="form-group row">
              <label for="Quantity" class="col-sm-3 form-control-label">Item</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="name" id="value" placeholder="Item">
              </div>
            </div>
            <div class="form-group row">
              <label for="Quantity" align="left" class="col-sm-3 form-control-label">Approx Value</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="approx_price" id="value" placeholder="Approx Value">
              </div>    
            </div>
            <div class="form-group row">
              <label for="Quantity" align="left" class="col-sm-3 form-control-label">Rough Cast Weight</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="cast_weight" id="value" placeholder="Rough Cast Weight">
              </div>    
            </div>
            <div class="form-group row">
              <label for="Quantity" align="left" class="col-sm-3 form-control-label">Scrap Weight</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="scrap_weight" id="value" placeholder="Scarp Weight">
              </div>    
            </div>
            <div class="form-group row">
              <label for="Quantity" align="left" class="col-sm-3 form-control-label">Finished Good Weight</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="good_weight" id="value" placeholder="Finished Good Weight">
              </div>    
            </div>
               
            <div class="form-group row m-t-md">
              <div align="right" class="col-sm-offset-2 col-sm-12">
                <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                <button name="submit_add_item" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
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
<?php include "../includes/footer.php";?>
