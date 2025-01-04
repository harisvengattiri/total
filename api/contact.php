<?php include "../config.php";?>
<?php
if(isset($_GET["id"]))
{

			$id=$_GET['id'];
			$sql = "SELECT * FROM customers where id=$id"; 
$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) 
		{
		while($row = mysqli_fetch_assoc($result)) 
		{
			$id=$row["id"];
			$name=$row["name"];
			$gst=$row["gst"];
			$person=$row["person"];
			$address=$row["address"];
			$email=$row["email"];
			$fax=$row["fax"];
			$phone=$row["phone"];
            $mobile=$row["mobile"];
			$type=$row["type"];
		}
		}
		

?>
		<div class="row-col white bg">
		<div class="row-row">
		<div class="row-body scrollable hover">
		<div class="row-inner">
 	      	<div class="p-a-lg text-center">
 			<?php   			  
  			  $butnclr[0]="cyan";
  			  $butnclr[1]="green";
  			  $butnclr[2]="pink";
  			  $butnclr[3]="blue-grey";
  			  $butnclr[4]="teal";
  			  $butnclr[5]="blue";
  			  $butnclr[6]="grey";
  			  $butnclr[7]="light-blue";
  			  $butnclr[8]="indigo";
  			  $butnclr[9]="brown";
  			  $j=0;
  			  $j=$id%10;
  			  ?>
 				<a href="#">
  				<span class="w-40 avatar circle animated rollIn <?php echo $butnclr[$j]; ?>">
  				<?php
 				$words = explode(" ", $name); 
  				$acronym = ""; 
  				foreach ($words as $w) 
  				{
					if (!empty($w)) {
						$acronym .= $w[0];
					 }
  				}
  				$acronym =strtoupper(substr($acronym,0,3));
  				echo $acronym;
  				?>
 				      			        </span></a>
 	      		<div class="animated fadeInUp">
 		      		<div>
			<span class="text-md m-t block"><?php echo ucwords($name); ?></span>
<br/>		
<a href="javascript:void(0);" onclick="contact_type('<?php echo $type; ?>')" class="btn btn-outline btn-sm rounded b-info text-info"><?php echo $type; ?></a>							
		</div>
  

 	            </div>
 	      	</div>
 			<div class="p-a-md animated fadeInUp">
 		        <ul class="nav">
 		           
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Contact Person <i class="fa fa-fw fa-user"></i></b>
 		                	</span>
 		                	<span><?php echo ucwords($person)."&nbsp;";?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Address <i class="fa fa-fw fa-map-marker"></i></b>
 		                	</span>
 		                	<span><?php echo $address."&nbsp;"; ?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>GST <i class="fa fa-fw fa-bank"></i></b>
 		                	</span>
 		                	<span><?php echo $gst."&nbsp;"; ?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Phone <i class="fa fa-fw fa-tty"></i></b>
 		                	</span>
 		                	<span><?php echo $phone."&nbsp;"; ?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Fax <i class="fa fa-fw fa-fax"></i></b>
 		                	</span>
 		                	<span><?php echo $fax."&nbsp;"; ?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Mobile <i class="fa fa-fw fa-phone-square"></i></b>
 		                	</span>
 		                	<span><?php echo $mobile."&nbsp;"; ?></span>
 		              	</a>
 		            </li>
 		            <li class="nav-item m-b-xs">
 		              	<a class="nav-link text-muted block">
 		                	<span class="pull-right text-sm">
 		                		<b>Email <i class="fa fa-fw fa-envelope"></i></b>
 		                	</span>
 		                	<span><?php echo $email."&nbsp;"; ?></span>
 		              	</a>
 		            </li></b>
 		        </ul>
 	        </div>
			</div>
					      	</div>
					    </div>

					    <!-- footer -->
					    <div class="p-a b-t clearfix">
					      	<div class="pull-right">
					      	    <?php
								session_start();
					      	    if($_SESSION['role'] == 'admin') {
					      	    ?>
					            <a href="<?php echo BASEURL; ?>/controller?controller=contacts&submit_delete_customer=delete&id=<?php echo $id;?>" onclick="return confirm('Are you sure?')" class="btn btn-xs white rounded">
					            	<i class="fa fa-trash m-r-xs"></i>
					            	Delete
					            </a>
					            <?php } ?>
					        </div>
					      	<a href="<?php echo BASEURL; ?>/edit/customer?id=<?php echo $id;?>" class="btn btn-xs primary rounded">
				            	<i class="fa fa-pencil m-r-xs"></i>
				            	Edit
				            </a>
					    </div>
					    <!-- / -->
				    </div>
				</div>
<?php
}
else
{		
		
	if($_GET) {
		$type = $_GET['type'];
	} else { $type = ''; }

		if($type != '')
		{
		$sql = "SELECT id,name,email FROM customers where type='$type' ORDER BY name ASC";
        }
		else if(isset($_POST["cname"]))
		{
		$cname=$_POST['cname'];
		$sql = "SELECT id,name,email FROM customers where name LIKE '%$cname%' ORDER BY name ASC";
		}
        else
		{
		$sql = "SELECT id,name,email FROM customers ORDER BY name ASC";
        }       
        $result = mysqli_query($conn, $sql);
	
?>
<div class="row-col">
	<div class="row-row">
	<div class="row-col">
	<div id="contactlist" class="col-xs">
<div class="row-col white bg">
	<!-- flex content -->
	<div class="row-row">
		<div class="row-body scrollable hover">
			<div class="row-inner">
				<div class="list" data-ui-list="b-r b-3x b-primary">
<?php 
																																																		$j=0; $i=0;
																																																		if (mysqli_num_rows($result) > 0) 
																																																		{
																																																		while($row = mysqli_fetch_assoc($result)) 
																																																		{
																																																		$id=$row["id"];
																																																		$i=$i+1;
																																								?>
																																								<div class="list-item ">
				<div class="list-left">
				<?php 				
				$butnclr[0]="cyan";
				$butnclr[1]="green";
				$butnclr[2]="pink";
				$butnclr[3]="blue-grey";
				$butnclr[4]="teal";
				$butnclr[5]="blue";
				$butnclr[6]="grey";
				$butnclr[7]="light-blue";
				$butnclr[8]="indigo";
				$butnclr[9]="brown";
				$j=$id%10;
				?>
					        <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"];?>)">
																																																		<span class="w-40 avatar circle <?php echo $butnclr[$j]; ?>">
																																																		<?php
$words = explode(" ", $row["name"]); 
																																																		$acronym = ""; 
																																																		foreach ($words as $w) {
																																																		if (!empty($w)) {	
																																																			$acronym .= $w[0];
																																																			}
																																																		}
																																																		$acronym =strtoupper(substr($acronym,0,3));
																																																		echo $acronym;
																																																		?>
					        </span></a>
					      </div>
					      <div class="list-body">
					        <div class="item-title">

					          <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"];?>)" class="_500"><td><?php echo ucwords($row["name"])?></td></a>
					        </div>
					        <small class="block text-muted text-ellipsis">
					            <a href="javascript:void(0);" onclick="getcontact(<?php echo $row["id"];?>)">
																																																												<?php echo $row["email"];?></a>
					        </small>
					      </div>
					    </div>
																																								<?php
																																																		}
} 

?>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
                                            <!-- footer -->
					    <div class="white bg p-a b-t clearfix">
					      	<div class="btn-group pull-right">
					            <a class="btn btn-xs white circle">#CybozCRM</a>
					        </div>
					      	<span class="text-sm text-muted">Total: <strong><?php echo $i; ?></strong></span>
					    </div>
</div>
</div>	

<?php
}
?>