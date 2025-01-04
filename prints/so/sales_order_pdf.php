<?php include"../config.php";?>
<?php include"../functions/functions.php";?>
<?php 
$dno=$_GET["dno"]; 
?>
<title>Mancon Delivery Note #<?php echo $dno;?></title>
<style>


table
{
    page-break-inside:auto;
    border-collapse: collapse;
    width: 100%;
    border: 1px solid black;
    padding: 2px;
    font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
}

tr, th, td {
    page-break-inside:avoid; page-break-after:auto ;
    height: 20px;
    border: 1px solid black;
    padding: 5px;
    font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
}

tr, th, td {
    page-break-inside:avoid; page-break-after:auto ;
    height: 20px;
    border: 1px solid black;
    padding: 5px;
    font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
}

p,li {
     word-spacing: 2px;
     line-height: 140%;
     font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
     font-size: 12px;
}
body, h1 {
     font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
     font-size: 12px;
}
    .wrapper{position:relative; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;}
    .right,.left{width:50%; position:absolute;}
    .right{right:0;}
    .left{left:0;}

</style>
<body>
<table style="width: 100%; border:0px">
<tr style="border:0px" >
<td style="width: 35%; border: 0px"></td>
<td align="center" style="width: 30%; border: 0px"><h2>DELIVERY NOTE</h2></td>
<td style="width: 35%; border: 0px"></td>
</tr>
</table>
<br/>
<?php 
        
        
             $sql="SELECT * FROM delivery_note where id='$dno'";
             
             $query=mysqli_query($conn,$sql);
             while($fetch=mysqli_fetch_array($query))
             {
                    $id=$fetch['id'];
                    $date=$fetch['date'];
                    $or=$fetch['order_referance'];
                    $customer=$fetch['customer'];
                  
                    $site=$fetch['customersite'];
                    $sqlsite="SELECT p_name from customer_site where id='$site'";
                    $querysite=mysqli_query($conn,$sqlsite);
                    $fetchsite=mysqli_fetch_array($querysite);
                    $site1=$fetchsite['p_name'];
                  
                    $vehi=$fetch['vehicle'];
                    $sqlveh="SELECT vehicle from vehicle where id='$vehi'";
                    $queryveh=mysqli_query($conn,$sqlveh);
                    $fetchveh=mysqli_fetch_array($queryveh);
                    $vehicle=$fetchveh['vehicle'];
                  
                    $dri=$fetch['driver'];
                    $sqldri="SELECT name from customers where id='$dri'";
                    $querydri=mysqli_query($conn,$sqldri);
                    $fetchdri=mysqli_fetch_array($querydri);
                    $driver=$fetchdri['name'];
                  
                  $print=$fetch['prints'];
                  
            $sql1="SELECT * FROM customer_site where customer='$customer' AND id='$site'";
            $query1=mysqli_query($conn,$sql1);
            while($fetch1=mysqli_fetch_array($query1))
                  {
                    $siteno=$fetch1['site'];
                    $pno=$fetch1['p_no'];
                    $loc1=$fetch1['location'];
                    $sqlloc="SELECT * FROM fair where id='$loc1'";
                    $queryloc=mysqli_query($conn,$sqlloc);
                    while($fetchloc=mysqli_fetch_array($queryloc))
                    {
                     $loc=$fetchloc['location'];
                    }
                    
                    $per=$fetch1['contact_per'];
                    $no=$fetch1['contact_no'];
                    $permit=$fetch1['permit'];
                    $contact=$fetch1['contact_no'];
                  }
            $sql2="SELECT * FROM customers where id='$customer'";
            $query2=mysqli_query($conn,$sql2);
            while($fetch2=mysqli_fetch_array($query2))
                  {
                    $id1=$fetch2['id'];
                    $cust=$fetch2['name'];
                    $address=$fetch2['address'];
                    $phone=$fetch2['phone'];
                    $fax=$fetch2['fax'];
                  }
            $sql3="SELECT * FROM sales_order where order_referance='$or'";
            $query3=mysqli_query($conn,$sql3);
            while($fetch3=mysqli_fetch_array($query3))
                  {
                    $lpo=$fetch3['lpo'];
                    $date1=$fetch3['date'];
                  }
             }
            $print=$print+1;
            $sql0="UPDATE delivery_note SET prints=$print where id='$dno'";
            $query0=mysqli_query($conn,$sql0);
        ?>

<table style="width: 100%;" cellspacing="0" cellpadding="0">
<tr style="border:0px">
<td style="width: 20%;">Customer No:</td>
<td><b><?php echo sprintf("%03d",$id1);?></b></td>
</tr>
<tr style="border:0px">
<td style="width: 20%;">Customer Name:</td>
<td><b><?php echo $cust;?></b></td>
</tr>
<tr style="border:0px">
<td style="width: 20%;">Address</td>
<td><b><?php echo $address;?></b></td>
</tr>
<tr style="border:0px">
<td style="width: 20%;">Phone:</td>
<td><b><?php echo $phone;?></b></td>
</tr>
<tr style="border:0px">
<td style="width: 20%;">Fax:</td>
<td><b><?php echo $fax;?></b></td>
</tr>
</table><br/><br/>
<table style="width: 100%;" cellspacing="0" cellpadding="0">
<tr style="border:0px" >
<td align="right" style="width: 15%;">Delivery No:</td>
<td><b>DN|<?php echo sprintf("%06d",$id);?></b></td>
<td align="right" style="width: 15%;">Project Name:</td>
<td><b><?php echo $site1;?></b></td>
</tr>
<tr style="border:0px" >
<td align="right" style="width: 15%;">Delivery Date:</td>
<td><b><?php echo $date;?></b></td>
<td align="right" style="width: 15%;">Building Permit:</td>
<td><b><?php echo $permit;?></b></td>
</tr>
<tr style="border:0px" >
<td align="right" style="width: 15%;">Order No:</td>
<td><b><?php echo $or;?></b></td>
<td align="right" style="width: 15%;">Project No:</td>
<td><b><?php echo $pno;?></b></td>
</tr>
<tr style="border:0px" >
<td align="right" style="width: 15%;">Order Date:</td>
<td><b><?php echo $date1;?></b></td>
<td align="right" style="width: 15%;">Contact Name:</td>
<td><b><?php echo $per;?></b></td>
</tr>
<tr style="border:0px" >
<td align="right" style="width: 15%;">LPO No:</td>
<td><b><?php echo $lpo;?></b></td>
<td align="right" style="width: 15%;">Contact Phone:</td>
<td><b><?php echo $no;?></b></td></tr>
<tr style="border:0px" >
<td align="right" style="width: 15%;"></td>
<td><b></b></td>
<td align="right" style="width: 15%;">Location:</td>
<td><b><?php echo $loc;?></b></td>
</tr>
</table>
<br/>
<h3>Delivery Details</h3>
<br/>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="2">
<tr>
<th style="width: 2%;">#</th>
<th style="width: 10%;">Product No.</th>
<th style="width: 26%;">Description</th>
<th style="width: 22%;">Dimensions</th>
<th style="width: 10%;">Batch</th>
<th style="width: 10%;">Production Date</th>
<th style="width: 8%;">COC No. (BBCE)</th>
<th style="width: 4%;">Bndl.</th>
<th style="width: 8%;">Qty (Pcs)</th>
</tr>

<?php
             $sql="SELECT * FROM delivery_item where delivery_id='$dno' AND batch!=''";
             $query=mysqli_query($conn,$sql);
             $qn1=0;
             while($fetch=mysqli_fetch_array($query))
             {
                  $sl++;
                  $item=$fetch['item'];
                  $batch=$fetch['batch'];
                  $pdate=$fetch['pdate'];
                  $coc=$fetch['coc'];
                  $quantity=$fetch['thisquantity'];
                  $price=$fetch['price'];
                  $total=$fetch['total'];
                  
                  
                 $sql1="SELECT items,dimension,description,unit,bundle FROM items where id='$item'"; 
                 $query1=mysqli_query($conn,$sql1);
                 while($fetch1=mysqli_fetch_array($query1))
                 {
                    $item1=$fetch1['items'];
                    $size=$fetch1['dimension'];
                    $prdno=$fetch1['description'];
                    $unit=$fetch1['unit'];
                    $bundle=$fetch1['bundle'];
                 }
                 $bdl=$quantity/$bundle;
                 $bndl=round($bdl,2);
             ?>

          <tr>
            <td align="center"><?php echo $sl;?></td>
            <td align="left"><?php echo $prdno;?></td>
            <td align="left"><?php echo $item1;?></td>
            <td align="left"><?php echo $size;?></td>
            <td align="center"><?php echo $batch;?></td>
            <td align="center"><?php echo $pdate;?></td>
            <td align="center"><?php echo substr($coc, 5);?></td>
            <td align="center"><?php echo $bndl;?></td>
            <td align="right"><?php echo $quantity;?></td>
          </tr>
<?php
$totalqty=$totalqty+$quantity;
}
?>
          <tr>
            <td colspan="8" align="right"><b>Grand Total&nbsp;</b></td>
            <td colspan="1" align="right"><b><?php echo $totalqty;?></b></td>
          </tr>
</table>
<?php
$brv=18-$sl;
for($i=0;$i<$brv;$i++)
{
echo "<br/>";
}
?>

<table style="width: 100%;" cellspacing="0" cellpadding="0">
<tr style="border:0px" >
<td style="width: 13%; border:0px"><br/><br/>Prepared By:<br/><br/></td>
<td style="border:0px" ><br/><br/><b><?php echo $_GET['open'];?></b><br/><br/></td>
<td style="width: 8%; border-right:0px"><br/><br/>Driver:<br/><br/></td>
<td style="width: 18%; border-left:0px"><b><br/><br/><?php echo $driver;?><br/><br/></b></td>
<td style="width: 13%; border:0px"><br/><br/>Recieved By:<br/><br/></td>
<td style="border:0px" ><br/><br/>....................................<br/><br/></td>
</tr>
<tr style="border:0px" >
<td style="width: 13%; border:0px"><br/><br/>Signature:<br/><br/></td>
<td style="border:0px" ><br/><br/>....................................<br/><br/></td>
<td style="width: 8%; border-right:0px"><br/><br/>Vehicle:<br/><br/></td>
<td style="width: 18%; border-left:0px"><b><br/><br/><?php echo $vehicle;?><br/><br/></b></td>
<td style="width: 13%; border:0px"><br/><br/>Signature:<br/><br/></td>
<td style="border:0px" ><br/><br/>....................................<br/><br/></td>
</tr>
<tr style="border:0px">
<td colspan="2" style="border-right:0px" ><br/></td>
<td colspan="2" style="border-right:0px" ><br/></td>
<td colspan="2" style="border-right:0px" ><br/></td>
</tr>
</table>
</body>
