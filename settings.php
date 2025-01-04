<?php include "config.php";?>
<?php include "includes/menu.php";?>

<div class="app-body">

<?php
$status="NULL";
if(isset($_GET['purpose']))
{
$purpose=$_GET["purpose"];
$id=$_GET["id"];
if($purpose=="customer_tag_delete")
{
$sql = "DELETE FROM `customer_tags` WHERE `id` = $id";
} 
if($purpose=="project_tag_delete")
{
$sql = "DELETE FROM `project_tags` WHERE `id` = $id";
} 
if($purpose=="maintenance_tag_delete")
{
$sql = "DELETE FROM `maintenance_tags` WHERE `id` = $id";
}  
if($purpose=="expense_category_delete")
{
$sql = "DELETE FROM `expense_categories` WHERE `id` = $id";
}
if($purpose=="expense_main_category_delete")
{
$sql = "DELETE FROM `expense_main_categories` WHERE `id` = $id";
}
if($purpose=="asset_category_delete")
{
$sql = "DELETE FROM `asset_categories` WHERE `id` = $id";
}  
if($purpose=="liability_category_delete")
{
$sql = "DELETE FROM `liability_categories` WHERE `id` = $id";
}
if($purpose=="asset_subcategory_delete")
{
$sql = "DELETE FROM `asset_subcategories` WHERE `id` = $id";
} 
if($purpose=="liability_subcategory_delete")
{
$sql = "DELETE FROM `liability_subcategories` WHERE `id` = $id";
} 
if($purpose=="expense_subcategory_delete")
{
$sql = "DELETE FROM `expense_subcategories` WHERE `id` = $id";
} 
if ($conn->query($sql) === TRUE) 
{ $status="deleted";
} else {
    $status="failed";
}
}

if(isset($_POST['add_customer_tag']))
{
$customer_tag=$_POST["customer_tag"];
$sql = "INSERT INTO `customer_tags` (`id`, `tag`) 
VALUES ('NULL', '$customer_tag')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_project_tag']))
{
$project_tag=$_POST["project_tag"];
$sql = "INSERT INTO `project_tags` (`id`, `tag`) 
VALUES ('NULL', '$project_tag')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_maintenance_tag']))
{
$maintenance_tag=$_POST["maintenance_tag"];
$sql = "INSERT INTO `maintenance_tags` (`id`, `tag`) 
VALUES ('NULL', '$maintenance_tag')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_expense_category']))
{
$expense_category=$_POST["expense_category"];
$exp_type=$_POST["exp_type"];
$sql = "INSERT INTO `expense_categories` (`id`, `tag`, `type`) 
VALUES ('NULL', '$expense_category','$exp_type')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_expense_main_category']))
{
    $sql_uid = "SELECT `id` FROM `expense_main_categories` ORDER BY `id` DESC LIMIT 1";
    $query_uid = mysqli_query($conn,$sql_uid);
    $result_uid = mysqli_fetch_array($query_uid);
    $last_id = $result_uid['id'];
    $new_uid = ($last_id+1)*1000;
    
$expense_main_category=$_POST["expense_main_category"];
$sql = "INSERT INTO `expense_main_categories` (`id`, `uid`, `tag`) 
VALUES ('NULL', '$new_uid', '$expense_main_category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_asset_category']))
{
$asset_category=$_POST["asset_category"];
$sql = "INSERT INTO `asset_categories` (`id`, `tag`) 
VALUES ('NULL', '$asset_category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_liability_category']))
{
$liability_category=$_POST["liability_category"];
$sql = "INSERT INTO `liability_categories` (`id`, `tag`) 
VALUES ('NULL', '$liability_category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_expense_subcategory']))
{
$parent=$_POST["parent"];
$category=$_POST["category"];
$sql = "INSERT INTO `expense_subcategories` (`id`, `parent`, `category`) 
VALUES ('NULL', '$parent', '$category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_asset_subcategory']))
{
$parent=$_POST["parent"];
$category=$_POST["category"];
$sql = "INSERT INTO `asset_subcategories` (`id`, `parent`, `category`) 
VALUES ('NULL', '$parent', '$category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}

elseif(isset($_POST['add_liability_subcategory']))
{
$parent=$_POST["parent"];
$category=$_POST["category"];
$sql = "INSERT INTO `liability_subcategories` (`id`, `parent`, `category`) 
VALUES ('NULL', '$parent', '$category')";
if ($conn->query($sql) === TRUE) {
    $status="success";
} else {
    $status="failed";
}}
?>



<!-- ############ PAGE START-->
<div class="row-col">
    <div class="col-md-12">
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
	<?php } else if($status=="deleted") { ?>
	<p><a class="list-group-item b-l-warning">
          <span class="pull-right text-warning"><i class="fa fa-circle text-xs"></i></span>
          <span class="label rounded label warning pos-rlt m-r-xs">
		  <b class="arrow right b-warning pull-in"></b><i class="ion-checkmark"></i></span>
		  <span class="text-warning">Your Deletion was Successfull!</span>
    </a></p>
	<?php }?>
  <div class="col-sm-3 col-lg-2 b-r">
    <div class="p-y">
      <div class="nav-active-border left b-primary">
        <ul class="nav nav-sm">
          <li class="nav-item">
            <a class="nav-link block active" href="#" data-toggle="tab" data-target="#profile">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link block" href="#" data-toggle="tab" data-target="#expense-main-categories">Main Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link block" href="#" data-toggle="tab" data-target="#expense-categories">Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link block" href="#" data-toggle="tab" data-target="#expense-subcategories">Sub Account</a>
          </li>
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#asset-categories">Asset Categories</a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#asset-subcategories">Asset SubCat.</a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#liability-categories">Liability Categories</a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#liability-subcategories">Liability SubCat.</a>-->
          <!--</li>-->
          
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#customer-tags">Customer Tags</a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#project-tags">Project Tags</a>-->
          <!--</li>-->
          <!--<li class="nav-item">-->
          <!--  <a class="nav-link block" href="#" data-toggle="tab" data-target="#maintenance-tags">Maintenance Tags</a>-->
          <!--</li>-->
          
          <li class="nav-item">
            <a class="nav-link block" href="#" data-toggle="tab" data-target="#security">Security</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-sm-9 col-lg-10 light bg">
    <div class="tab-content pos-rlt">

      <div class="tab-pane" id="asset-subcategories">
        <div class="p-a-md b-b _600">Asset Sub Categories</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from asset_subcategories";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
                $category=$row['category'];
                $parent=$row['parent'];
                $id=$row['id'];
                                $sql2 = "SELECT tag FROM asset_categories where id=$parent";
				$result2 = mysqli_query($conn, $sql2);
				if (mysqli_num_rows($result2) > 0) 
				{
				while($row2 = mysqli_fetch_assoc($result2)) 
				{
                                $parent_name=$row2['tag'];
				}}  
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $category." [#".$parent_name."]"; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=asset_subcategory_delete&id=<?php echo $id; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4"> 
<select name="parent" id="parent" placeholder="Parent" class="form-control select2" data-ui-options="{theme: 'bootstrap'}">
				<?php 
				$sql = "SELECT * FROM asset_categories";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) 
				{
				while($row = mysqli_fetch_assoc($result)) 
				{
				?>
				<option value="<?php echo $row["id"]; ?>"><?php echo $row["tag"]?></option>
				<?php 
				}} 
				?>
				</select>
        </div>
        <div class="col-sm-4">
        <input type="text" class="form-control" name="category" id="category" placeholder="Enter New Asset Sub Category">
        </div>
        <div class="col-sm-2">
                <button name="add_asset_subcategory" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div> 
        </form>
      </div>





      <div class="tab-pane" id="liability-subcategories">
        <div class="p-a-md b-b _600">Liability Sub Categories</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from liability_subcategories";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
                $category=$row['category'];
                $parent=$row['parent'];
                $id=$row['id'];
                                $sql2 = "SELECT tag FROM liability_categories where id=$parent";
				$result2 = mysqli_query($conn, $sql2);
				if (mysqli_num_rows($result2) > 0) 
				{
				while($row2 = mysqli_fetch_assoc($result2)) 
				{
                                $parent_name=$row2['tag'];
				}}  
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $category." [#".$parent_name."]"; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=liability_subcategory_delete&id=<?php echo $id; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4"> 
<select name="parent" id="parent" placeholder="Parent" class="form-control select2" data-ui-options="{theme: 'bootstrap'}">
				<?php 
				$sql = "SELECT * FROM liability_categories";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) 
				{
				while($row = mysqli_fetch_assoc($result)) 
				{
				?>
				<option value="<?php echo $row["id"]; ?>"><?php echo $row["tag"]?></option>
				<?php 
				}} 
				?>
				</select>
        </div>
        <div class="col-sm-4">
        <input type="text" class="form-control" name="category" id="category" placeholder="Enter New liability Sub Category">
        </div>
        <div class="col-sm-2">
                <button name="add_liability_subcategory" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div> 
        </form>
      </div>








      <div class="tab-pane" id="expense-subcategories">
        <div class="p-a-md b-b _600">Sub Accounts</div>
        
        <div class="box-body">
        	<span style="float: left;"></span>
            <span style="float: right;">Search: <input id="filter" type="text" class="form-control form-control-sm input-sm w-auto inline m-r"/></span>
        </div>
        
        <!--<div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >-->
        <table class="table m-b-none" data-ui-jp="footable" data-filter="#filter" style="width:90%;">
        <thead>
          <tr>
            <th>Sl No</th>
            <th>ID</th>
            <th>Category</th>
            <th>Parent Category</th>
            <th>Main Category</th>
            <th>Opening Balance</th>
            <th>Action</th>
          </tr>
        </thead>
          <tbody>
          <?php
          $sql = "SELECT expsub.category AS cat,expsub.id AS id,expsub.op_bal AS op_bal,expsub.uid AS uid,expcat.tag AS parent,expmain.tag AS maincat
                  FROM expense_subcategories expsub
                  INNER JOIN expense_categories expcat ON expsub.parent=expcat.id
                  INNER JOIN expense_main_categories expmain ON expcat.type=expmain.id
                  ORDER BY expcat.tag,expsub.uid";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) 
              { $sub_cat_cnt = 0;         
              while($row = mysqli_fetch_assoc($result)) 
              {
                $id = $row['id'];
                $uid = $row['uid'];
                $sub_cat_cnt++;
          ?>

          <tr>
            <td><?php echo $sub_cat_cnt;?></td>
            <td><?php echo $uid;?></td>
            <td><?php echo $row['cat'];?></td>
            <td><?php echo $row['parent'];?></td>
            <td><?php echo $row['maincat'];?></td>
            <td><?php echo $row['op_bal'];?></td>
            
            <?php // if($_SESSION['username'] == 'developer') { ?>
            <td>
            <button class="btn btn-sm btn-outline b-primary text-primary">
              <a href="<?php echo BASEURL; ?>/edit/settings?purpose=sub_edit&id=<?php echo $id; ?>">
              <i class="fa fa-pencil"></i></a>
            </button>&nbsp;
            </td>
            <?php // } ?>
            
            <!--<td>-->
            <!--<button class="btn btn-sm btn-outline b-danger text-danger">-->
            <!--  <a href="<?php // echo BASEURL; ?>/settings?purpose=expense_subcategory_delete&id=<?php // echo $id; ?>" onclick="return confirm('Are you sure?')">-->
            <!--  <i class="fa fa-close"></i></a>-->
            <!--</button>&nbsp;-->
            <!--</td>-->
            
            
          </tr>
          <?php }	} ?>
          </tbody>
           <tfoot class="hide-if-no-paging">
           <tr>
              <td colspan="5" class="text-center">
                  <ul class="pagination"></ul>
              </td>
           </tr>
         </tfoot>
        </table>
        <!--</div>-->
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post" style="margin-bottom:85px;">
        <div class="col-sm-4"> 
<select name="parent" id="parent" placeholder="Parent" class="form-control select2" data-ui-options="{theme: 'bootstrap'}">
				<?php 
				$sql = "SELECT * FROM expense_categories";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0) 
				{
				while($row = mysqli_fetch_assoc($result)) 
				{
				?>
				<option value="<?php echo $row["id"]; ?>"><?php echo $row["tag"]?></option>
				<?php 
				}} 
				?>
				</select>
        </div>
        <div class="col-sm-4">
        <input type="text" class="form-control" name="category" id="category" placeholder="Enter New Sub Category">
        </div>
        <div class="col-sm-2">
                <button name="add_expense_subcategory" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div> 
        </form>
      </div>






      <div class="tab-pane" id="customer-tags">
        <div class="p-a-md b-b _600">Customer Tags</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from customer_tags";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $row['tag']; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=customer_tag_delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="customer_tag" id="customer_tag" placeholder="Enter New Customer Tag">
        </div>
        <div class="col-sm-3">
                <button name="add_customer_tag" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>


<div class="tab-pane" id="expense-main-categories">
    <div class="p-a-md b-b _600">Main Categories</div>
    <!--<div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >-->
    <table class="table m-b-none" style="width:50%;">
        <thead>
          <tr>
            <th>Sl No</th>
            <th>ID</th>
            <th>Main Category</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * from expense_main_categories";
        $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{ $main_cat_cnt = 0;
		while($row = mysqli_fetch_assoc($result)) 
		{ $main_cat_cnt++;
        ?>
        <tr>
            <td><?php echo $main_cat_cnt;?></td>
            <td><?php echo $row['uid'];?></td>
            <td><?php echo $row['tag'];?></td>
            
            <?php // if($_SESSION['username'] == 'developer') { ?>
            <td>
                <button class="btn btn-sm btn-outline b-primary text-primary">
                <a href="<?php echo BASEURL; ?>/edit/settings?purpose=main_edit&id=<?php echo $row['id']; ?>">
                <i class="fa fa-pencil"></i></a>
                </button>&nbsp;
            </td>
            <?php // } ?>
            
            <!--<td>-->
            <!--    <button class="btn btn-sm btn-outline b-danger text-danger">-->
            <!--    <a href="<?php // echo BASEURL; ?>/settings?purpose=expense_main_category_delete&id=<?php // echo $row['id']; ?>" onclick="return confirm('Are you sure?')">-->
            <!--    <i class="fa fa-close"></i></a>-->
            <!--    </button>&nbsp;-->
            <!--</td>-->
        </tr>
        <?php
        }
		}
	?>
	    </tbody>
    </table>
    <!--</div>-->
    <form role="form" action="<?php echo BASEURL;?>/settings" method="post" style="margin-bottom:85px;">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="expense_main_category" placeholder="Enter New Main Category">
        </div>
        <div class="col-sm-3">
                <button name="add_expense_main_category" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
    </form>
</div>

<div class="tab-pane" id="expense-categories">
        <div class="p-a-md b-b _600">Accounts</div>
        <!--<div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >-->
        <table class="table m-b-none" style="width:60%;">
        <thead>
          <tr>
            <th>Sl No</th>
            <th>ID</th>
            <th>Category</th>
            <th>Category Type</th>
            <th>Main Category</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT excat.id AS id,excat.tag AS tag,excat.uid AS uid,excat.entry AS entry,exmain.tag AS main FROM
                    expense_categories excat INNER JOIN expense_main_categories exmain ON exmain.id=excat.type
                    ORDER BY exmain.tag,excat.uid";
            $result = mysqli_query($conn, $sql);
		    if (mysqli_num_rows($result) > 0) 
		    {
            $cat_count = 0;
		    while($row = mysqli_fetch_assoc($result)) 
		    { $cat_count++;
            ?>
              <tr>
                <td><?php echo $cat_count;?></td>
                <td><?php echo $row['uid'];?></td>
                <td><?php echo $row['tag'];?></td>
                <td><?php echo $row['entry'];?></td>
                <td><?php echo $row['main'];?></td>
                
                <?php // if($_SESSION['username'] == 'developer') { ?>
                <td><button class="btn btn-sm btn-outline b-primary text-primary">
                      <a href="<?php echo BASEURL; ?>/edit/settings?purpose=cat_edit&id=<?php echo $row['id']; ?>">
                      <i class="fa fa-pencil"></i></a>
                    </button>&nbsp;
                 </td>
                <?php // } ?>
                
                <!--<td><button class="btn btn-sm btn-outline b-danger text-danger">-->
                <!--      <a href="<?php // echo BASEURL; ?>/settings?purpose=expense_category_delete&id=<?php // echo $row['id']; ?>" onclick="return confirm('Are you sure?')">-->
                <!--      <i class="fa fa-close"></i></a>-->
                <!--    </button>&nbsp;-->
                <!-- </td>-->
                 
                 
              </tr> 
            <?php } }	?>
        </tbody>
        </table>
        <!--</div>-->
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post" style="margin-bottom:85px;">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="expense_category" id="expense_category" placeholder="Enter New Category">
        </div>
        <div class="col-sm-4">
        <select class="form-control" name="exp_type" required>
            <option value="">SELECT TYPE</option>
            <?php
                $sql = "SELECT * from `expense_main_categories`";
                $result = mysqli_query($conn, $sql);
        		if (mysqli_num_rows($result) > 0) 
        		{
        		while($row = mysqli_fetch_assoc($result)) 
        		{
            ?>
            <option value="<?php echo $row['id'];?>"><?php echo $row['tag'];?></option>
            <?php } } ?>
        </select>
        </div>
        <div class="col-sm-3">
                <button name="add_expense_category" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>



<div class="tab-pane" id="asset-categories">
        <div class="p-a-md b-b _600">Asset Categories</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from asset_categories";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $row['tag']; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=asset_category_delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="asset_category" id="asset_category" placeholder="Enter New Asset Category">
        </div>
        <div class="col-sm-3">
                <button name="add_asset_category" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>



<div class="tab-pane" id="liability-categories">
        <div class="p-a-md b-b _600">Liability Categories</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from liability_categories";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $row['tag']; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=liability_category_delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="liability_category" id="liability_category" placeholder="Enter New Liability Category">
        </div>
        <div class="col-sm-3">
                <button name="add_liability_category" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>


      <div class="tab-pane" id="project-tags">
        <div class="p-a-md b-b _600">Project Tags</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from project_tags";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $row['tag']; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=project_tag_delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="project_tag" id="project_tag" placeholder="Enter New Project Tag">
        </div>
        <div class="col-sm-3">
                <button name="add_project_tag" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>




      <div class="tab-pane" id="maintenance-tags">
        <div class="p-a-md b-b _600">Maintenance Tags</div>
        <div class="p-a-md col-md-12"  style="display:inline-block; line-height:45px; vertical-align: top" >
        <?php
                $sql = "SELECT * from maintenance_tags";
                $result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
                
		while($row = mysqli_fetch_assoc($result)) 
		{
        ?>
              <button class="btn btn-outline b-danger text-danger"><?php echo $row['tag']; ?> 
              <a href="<?php echo BASEURL; ?>/settings?purpose=maintenance_tag_delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">
              <i class="fa fa-close"></i></a></button>&nbsp;
        <?php
                }
		}
	?>
        </div>
        <form role="form" action="<?php echo BASEURL;?>/settings" method="post">
        <div class="col-sm-4">
        <input type="text" class="form-control" name="maintenance_tag" id="maintenance_tag" placeholder="Enter New Maintenance Tag">
        </div>
        <div class="col-sm-3">
                <button name="add_maintenance_tag" type="submit" class="btn btn-outline rounded b-success text-success">Add</button>
        </div>
        </form>
      </div>



      <div class="tab-pane active" id="profile">
        <div class="p-a-md b-b _600">Public profile</div>
        <form role="form" class="p-a-md col-md-6">
          <div class="form-group">
            <label>Profile picture</label>
            <div class="form-file">
              <input type="file">
              <button class="btn white">Upload new picture</button>
            </div>
          </div>
          <div class="form-group">
            <label>First Name</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Last Name</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>URL</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Company</label>
            <input type="text" class="form-control">
          </div>
          <div class="form-group">
            <label>Location</label>
            <input type="text" class="form-control">
          </div>
          <div class="checkbox">
            <label class="ui-check">
              <input type="checkbox"><i class="dark-white"></i> Available for hire
            </label>
          </div>
          <button type="submit" class="btn btn-info m-t">Update</button>
        </form>
      </div>



      <div class="tab-pane" id="security">
        <div class="p-a-md b-b _600">Security</div>
        <div class="p-a-md">
          <div class="clearfix m-b-lg">
            <form role="form" class="col-md-6 p-a-0">
              <div class="form-group">
                <label>Old Password</label>
                <input type="password" class="form-control">
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control">
              </div>
              <div class="form-group">
                <label>New Password Again</label>
                <input type="password" class="form-control">
              </div>
              <button type="submit" class="btn btn-info m-t">Update</button>
            </form>
          </div>

          <p><strong>Delete account?</strong></p>
          <button type="submit" class="btn btn-danger m-t" data-toggle="modal" data-target="#modal">Delete Account</button>

        </div>
      </div>
    </div>
  </div>
</div>


<!-- .modal -->
<div id="modal" class="modal fade animate black-overlay" data-backdrop="false">
  <div class="row-col h-v">
    <div class="row-cell v-m">
      <div class="modal-dialog modal-sm">
        <div class="modal-content flip-y">
          <div class="modal-body text-center">          
            <p class="p-y m-t"><i class="fa fa-remove text-warning fa-3x"></i></p>
            <p>Are you sure to delete your account?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn white p-x-md" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger p-x-md" data-dismiss="modal">Yes</button>
          </div>
        </div><!-- /.modal-content -->
      </div>
    </div>
  </div>
</div>
<!-- / .modal -->

<!-- ############ PAGE END-->


    </div>
  </div>
  <!-- / -->

<?php include "includes/footer.php";?>
