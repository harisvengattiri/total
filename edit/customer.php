<?php require_once "../includes/menu.php"; ?>
<?php require_once("../database.php"); ?>
<?php 
    $status = getStatusFromUrl();

    if ($_GET) { $cid = $_GET["id"];}
    $customer_details = getCustomerDetails($cid);
    $slmn = $customer_details['slmn'];
      if (!$slmn) {
          $sales_man = '';
      } else {
          $sales_man = getContactNameFromId($slmn);
      }
?>

<div class="app-body">
  <!-- ############ PAGE START-->
  <div class="padding">
    <div class="row">
      <div class="col-md-12">
        <?php if ($status == "success") { ?>
          <p><a class="list-group-item b-l-success">
              <span class="pull-right text-success"><i class="fa fa-circle text-xs"></i></span>
              <span class="label rounded label success pos-rlt m-r-xs">
                <b class="arrow right b-success pull-in"></b><i class="ion-checkmark"></i></span>
              <span class="text-success">Your Submission was Successfull!</span>
            </a></p>
        <?php } else if ($status == "failed") { ?>
          <p><a class="list-group-item b-l-danger">
              <span class="pull-right text-danger"><i class="fa fa-circle text-xs"></i></span>
              <span class="label rounded label danger pos-rlt m-r-xs">
                <b class="arrow right b-danger pull-in"></b><i class="ion-checkmark"></i></span>
              <span class="text-danger">Your Submission was Failed!</span>
            </a></p>
        <?php } ?>
        <div class="box">
          <div class="box-header">
            <h2>Edit Contact</h2>
          </div>
          <div class="box-divider m-a-0"></div>
          <div class="box-body">
            <form role="form" action="<?php echo BASEURL; ?>/controller" method="post">
              <input type="hidden" name="controller" value="contacts">
              <div class="form-group row">
                <label for="name" class="col-sm-2 form-control-label">Customer ID</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['id'];?>" readonly>
                </div>
              </div>

              <div class="form-group row">
                <input name="id" type="text" value="<?php echo $customer_details['id']; ?>" hidden="hidden">
                <label for="name" class="col-sm-2 form-control-label">Contact Name</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['name']; ?>" name="name" id="name" placeholder="Name of Company/Customer/Staff">
                </div>
                <label for="person" align="right" class="col-sm-2 form-control-label">Contact Person / Designation</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['person']; ?>" name="person" id="person" placeholder="Contact Person if Company / Designation if Individual">
                </div>
              </div>
              <div class="form-group row">
                <label for="address" class="col-sm-2 form-control-label">Address</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['address']; ?>" name="address" id="address" placeholder="Address">
                </div>
                <label for="tin" align="right" class="col-sm-1 form-control-label">GST No</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" value="<?php echo $customer_details['gst']; ?>" name="gst" id="gst" placeholder="GST No">
                </div>
              </div>
              <div class="form-group row">
                <label for="phone" class="col-sm-2 form-control-label">Phone</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['phone']; ?>" name="phone" id="phone" placeholder="Phone No">
                </div>
                <label for="fax" align="right" class="col-sm-1 form-control-label">Fax</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" value="<?php echo $customer_details['fax']; ?>" name="fax" id="fax" placeholder="Fax No">
                </div>
              </div>
              <div class="form-group row">
                <label for="mobile" class="col-sm-2 form-control-label">Mobile</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" value="<?php echo $customer_details['mobile']; ?>" name="mobile" id="mobile" placeholder="Mobile No">
                </div>
                <label for="email" align="right" class="col-sm-1 form-control-label">Email</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" value="<?php echo $customer_details['email']; ?>" name="email" id="email" placeholder="Email ID">
                </div>
              </div>
              <div class="form-group row">
                <label for="type" class="col-sm-2 form-control-label">Contact Type</label>
                <div class="col-sm-4">
                  <select name="type" class="form-control c-select">
                    <option><?php echo $customer_details['type']; ?></option>
                    <option>Company</option>
                    <option>Individual</option>
                    <option>Partner</option>
                    <option>Staff</option>
                    <option>Supplier</option>
                    <option>Bank</option>
                    <option>SalesRep</option>
                    <option>Operator</option>
                    <option>Driver</option>
                  </select>
                </div>
                <label for="type" align="right" class="col-sm-1 form-control-label">SalesMan</label>
                <div class="col-sm-5">
                  <select name="slmn" class="form-control c-select">
                    <option value="<?php echo $customer_details['slmn']; ?>"><?php echo $sales_man; ?></option>
                    <?php
                    $sql_sm = "SELECT id,name FROM `customers` WHERE `type` = 'SalesRep'";
                    $query_sm = mysqli_query($conn, $sql_sm);
                    while ($fetch_sm = mysqli_fetch_array($query_sm)) {
                    ?>
                      <option value="<?php echo $fetch_sm['id']; ?>"><?php echo $fetch_sm['name']; ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>


              <div class="form-group row m-t-md">
                <div align="right" class="col-sm-offset-2 col-sm-12">
                  <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                  <button name="submit_edit_customer" type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
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
<?php include "../includes/footer.php"; ?>