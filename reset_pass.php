<?php include "config.php";?>
<?php include "includes/menu.php";?>
<?php
$user=$_SESSION['userid'];

$sql = "SELECT * FROM `users` WHERE id=$user";
$query = mysqli_query($conn,$sql);
$fetch = mysqli_fetch_array($query);
$username = $fetch['username'];
$pre_pass = $fetch['pwd'];

if(isset($_POST['submit']))
{
$i = 0;
$pass=$_POST["pass"];
$vpass=$_POST["vpass"];
if($pass != $vpass) {$i++; $msg = 'Password verification was failed';$status="failed1";}
$cpass=$_POST["cpass"];
if(md5($cpass) != $pre_pass) {$i++; $msg = 'You have entered a wrong password. Try again!';$status="failed1";}

if(isset($_SESSION['userid']) && $i==0)
{
$pass = md5($pass);
$sql = "UPDATE `users` SET `pwd` = '$pass' WHERE `id` = $user";
if ($conn->query($sql) === TRUE) {
    $status="success";
       $date1=date("d/m/Y h:i:s a");
       $username=$_SESSION['username'];
       $code="USR".$user;
       $query=mysqli_real_escape_string($conn, $sql);
       $sql = "INSERT INTO activity_log (time, process, code, user, query) 
                  values ('$date1', 'edit', '$code', '$username', '$query')";
       $result = mysqli_query($conn, $sql);
} else {
    $status="failed";
}}}
?>

<div class="app-body">
<!-- ############ PAGE START-->
<div class="padding">
    <?php if($status=="success") {?>
	<p><a class="list-group-item b-l-success">
          <span class="pull-right text-success"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label success pos-rlt m-r-xs">
		  <b class="arrow right b-success pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-success">Your Password was Successfully Changed!</span>
    </a></p>
	<?php } else if($status=="failed") { ?>
	<p><a class="list-group-item b-l-danger">
          <span class="pull-right text-danger"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label danger pos-rlt m-r-xs">
		  <b class="arrow right b-danger pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-danger">Your Password Changing was Failed!</span>
    </a></p>
	<?php } else if($status=="failed1") {?>
	<p><a class="list-group-item b-l-danger">
          <span class="pull-right text-danger"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label danger pos-rlt m-r-xs">
		  <b class="arrow right b-danger pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-danger"><?php echo $msg;?></span>
    </a></p>
	<?php }?>
  <div class="box">
    <div class="box-header">
	<span style="float: left;"><h2>Reset Password of [<?php echo $username;?>]</h2></span> 
    <span style="float: right;">&nbsp;
</span>
    </div><br/>
    <div class="box-body">
       <form role="form" action="<?php echo BASEURL;?>/reset_pass" method="post">
            <!--<div class="form-group row">-->
            <!--    <label for="Quantity" class="col-sm-2 form-control-label">User Name</label>-->
            <!--    <div class="col-sm-6">-->
            <!--        <input type="text" class="form-control" name="username" value="<?php echo $username;?>" required>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="form-group row">
                 <label for="Quantity" class="col-sm-2 form-control-label">New Password</label>
              <div class="col-sm-6">
                <input type="password" class="form-control" name="pass" placeholder="New Password" required>
              </div>
            </div>
            <div class="form-group row">
                <label for="Quantity" class="col-sm-2 form-control-label">Verify New Password</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="vpass" placeholder="Verify New Password" required>
                </div>
            </div>
            <div class="form-group row">
                 <label for="Quantity" class="col-sm-2 form-control-label">Current Password</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="cpass" placeholder="Current Password" required>
              </div>
            </div>
            <div class="form-group row">
              <div align="right" class="col-sm-offset-2 col-sm-8">
                <button type="reset" class="btn btn-sm btn-outline rounded b-danger text-danger">Clear</button>
                <button name="submit"type="submit" class="btn btn-sm btn-outline rounded b-success text-success">Save</button>
              </div>
            </div>
          </form>    
    </div>

  </div>
</div>

<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->

<?php include "includes/footer.php";?>
