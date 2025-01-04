<?php require_once "../database.php";?>

<?php 
$return = $_GET["id"]; 
?>
<title>Goods Return Note #<?php echo $return;?></title>

<body>
<table style="width: 100%; border:0px">
<tr style="border:0px" >
    <td style="width: 20%; border: 0px"></td>
    <td align="center" style="width: 60%; border: 0px"><h2>GOODS RETURN NOTE</h2>
        <h4>TRN 100061540900003</h4>
    </td>
    <td style="width: 20%; border: 0px"></td>
</tr>
</table>
<br/>

     <?php 
        $return_details = getReturnDetails($return);
          $date = $return_details['date'];
          $customer = $return_details['customer'];
            $customer_details = getCustomerDetails($customer);
              $customer_name = $customer_details['name'];
              $customer_address = $customer_details['address'];
              $customer_phone = $customer_details['phone'];
              $customer_fax = $customer_details['fax'];
              $customer_gst = $customer_details['gst'];
          
          $sub_total = $return_details['subtotal'];
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
<td style="width: 18%;">GR Number:</td>
<td><b>GR|<?php echo sprintf('%06d',$return);?></b></td>
<td style="width: 15%;">GRN Date:</td>
<td><b><?php echo $date;?></b></td>
</tr>


</table>
<br/>
<h3>Goods Return Details</h3>
<br/>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="2">
<tr>
<th style="width: 3%;">#</th>
<th style="width: 14%;">JW Number.</th>
<th style="width: 14%;">Item</th>
<th style="width: 14%;">Good Status</th>
<th style="width: 14%;">Good Weight</th>
<th style="width: 9%;">Quantity</th>
</tr>

        <?php
            $return_items = getReturnItemDetails($return);
            $sl=1;
            $total_quantity = 0;
            $total_itemGoodWeight = 0;
            foreach($return_items as $return_item) {
                $item = $return_item['item'];
                $jw = $return_item['jw'];
                $quantity = $return_item['quantity'];
                $itemDetails = getItemDetails($item);
                  $good_weight = $itemDetails['good_weight'];
                  $itemGoodWeight = $good_weight * $quantity;
                $goods_status = getGoodStatusName($return_item['status']);
        ?>
          <tr>
            <td align="center"><?php echo $sl;?></td>
            <td align="center"><?php echo $jw;?></td>
            <td align="center"><?php echo $itemDetails['name'];?></td>
            <td align="center"><?php echo $goods_status;?></td>
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
