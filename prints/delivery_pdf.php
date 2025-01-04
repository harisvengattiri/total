<?php require_once "../database.php";?>

<?php 
$delivery = $_GET["id"]; 
?>
<title>Delivery Note #<?php echo $delivery;?></title>

<body>
<table style="width: 100%; border:0px">
<tr style="border:0px" >
<td style="width: 35%; border: 0px"></td>
<td align="center" style="width: 30%; border: 0px"><h2>DELIVERY NOTE</h2>
<h4>TRN 100061540900003</h4>
</td>
<td style="width: 35%; border: 0px"></td>
</tr>
</table>
<br/>

     <?php 
        $delivery_details = getDeliveryDetails($delivery);
          $date = $delivery_details['date'];
          $customer = $delivery_details['customer'];
            $customer_details = getCustomerDetails($customer);
              $customer_name = $customer_details['name'];
              $customer_address = $customer_details['address'];
              $customer_phone = $customer_details['phone'];
              $customer_fax = $customer_details['fax'];
              $customer_gst = $customer_details['gst'];
          
          $sub_total = $delivery_details['subtotal'];
          $sub_total = ($sub_total != NULL) ? $sub_total : 0;
        ?>



<table style="width: 100%;" cellspacing="0" cellpadding="0">
<tr>
<td style="width: 18%;">Customer No:</td>
<td><b>CST <?php echo sprintf('%04d',$customer);?></b></td>
<td style="width: 15%;">TRN:</td>
<td><b><?php echo $customer_gst;?></b></td>
</tr>
<tr>
<td style="width: 18%;">Customer Name:</td>
<td colspan="3"><b><?php echo $customer_name;?></b></td>
</tr>
<tr>
<td style="width: 18%;">Address:</td>
<td colspan="3"><b><?php echo $customer_address;?></b></td>
</tr>
<tr>
<td style="width: 18%;">Phone:</td>
<td><b><?php echo $customer_phone;?></b></td>
<td style="width: 15%;">FAX:</td>
<td><b><?php echo $customer_fax;?></b></td>
</tr>

<tr>
<td style="width: 18%;">Delivery No:</td>
<td><b>DN|<?php echo sprintf('%06d',$delivery);?></b></td>
<td style="width: 15%;">Delivery Date:</td>
<td><b><?php echo $date;?></b></td>
</tr>


</table>
<br/>
<h3>Delivery Details</h3>
<br/>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="2">
<tr>
<th style="width: 3%;">#</th>
<th style="width: 14%;">JW Number.</th>
<th style="width: 14%;">Item</th>
<th style="width: 14%;">Remark</th>
<th style="width: 14%;">Good Weight</th>
<th style="width: 9%;">Quantity</th>
</tr>

        <?php
             $sql="SELECT * FROM delivery_item where delivery_id = '$delivery'";
             $query=mysqli_query($conn,$sql);
             $sl=1;
             $total_quantity = 0;
             $total_itemGoodWeight = 0;
             while($fetch=mysqli_fetch_array($query))
             {
                  $item = $fetch['item'];
                  $jw = $fetch['jw'];
                  $quantity = $fetch['quantity'];
                  $remarkId = $fetch['delivery_remark'];
                  $remark = getRemarkOfdeliveryItem($remarkId);
                  $itemDetails = getItemDetails($item);
                    $good_weight = $itemDetails['good_weight'];
                    $itemGoodWeight = $good_weight * $quantity;
        ?>
          <tr>
            <td align="center"><?php echo $sl;?></td>
            <td align="center"><?php echo $jw;?></td>
            <td align="center"><?php echo $itemDetails['name'];?></td>
            <td align="center"><?php echo $remark;?></td>
            <td align="center"><?php echo $good_weight;?></td>
            <td align="center"><?php echo $quantity;?></td>
            <?php $itemDetails['good_weight']?>
          </tr>
          <?php
            $total_quantity = $total_quantity + $quantity;
            $total_itemGoodWeight = $total_itemGoodWeight+$itemGoodWeight;
            $sl++;}
          ?>
          <tr>
            <td colspan="5" align="right"><b>Total Quantity&nbsp;</b></td>
            <td colspan="1" align="center"><b><?php echo $total_quantity;?></b></td>
          </tr>
</table>
<br/>
<table style="width:50%;margin-left:auto;" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <th style="width: 60%;">Total Weight in Kg</th>
    <td align="center"><?php echo $total_itemGoodWeight;?></td>
  </tr>
  <tr>
    <th style="width: 60%;">Approx Value in Rs</th>
    <td align="center"><?php echo $sub_total;?></td>
  </tr>
</table>

<?php
$brv = 25-$sl;
for($i=0;$i<$brv;$i++)
{
echo "<br/>";
}
?>
<p align="justify">Bank Details Here ...</p>
<table style="width: 100%; border:0px" cellspacing="0" cellpadding="0">

<tr style="border:0px" >    
<td style="width: 13%; border:0px"><br/><br/>Received By:<br/><br/></td>
<td style="border:0px" ><br/><br/><b>....................</b><br/><br/></td>         
<td style="width: 40%; border:0px"><br/><br/><br/><br/></td>
<td style="width: 13%; border:0px"><br/><br/>Prepared By:<br/><br/></td>
<td style="border:0px" ><br/><br/><b>Admin</b><br/><br/></td>
</tr>    

<tr style="border:0px" > 
<td style="width: 13%; border:0px"><br/><br/>Signature:<br/><br/></td>
<td style="border:0px" ><br/><br/>........................<br/><br/></td>    
    
<td style="width: 40%; border:0px"><br/><br/><br/><br/></td>

<td style="width: 13%; border:0px"><br/><br/>Signature:<br/><br/></td>
<td style="border:0px" ><br/><br/>....................<br/><br/></td>
</tr>
</table>
</body>
