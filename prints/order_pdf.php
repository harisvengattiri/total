<?php require_once "../database.php";?>

<?php 
$order = $_GET["id"]; 
?>
<title>Delivery Order #<?php echo $order;?></title>

<body>
<table style="width: 100%; border:0px">
<tr style="border:0px" >
<td style="width: 35%; border: 0px"></td>
<td align="center" style="width: 30%; border: 0px"><h2>DELIVERY ORDER</h2>
<h4>TRN 100061540900003</h4>
</td>
<td style="width: 35%; border: 0px"></td>
</tr>
</table>
<br/>

     <?php 
        $order_details = getOrderDetails($order);
          $date = $order_details['date'];
          $customer = $order_details['customer'];
            $customer_details = getCustomerDetails($customer);
              $customer_name = $customer_details['name'];
              $customer_address = $customer_details['address'];
              $customer_phone = $customer_details['phone'];
              $customer_fax = $customer_details['fax'];
              $customer_gst = $customer_details['gst'];

          $jw = $order_details['jw'];
          
          $sub_total = $order_details['subtotal'];
          $sub_total = ($sub_total != NULL) ? $sub_total : 0;

          $vat = $order_details['vat'];
          $vat = ($vat != NULL) ? $vat : 0;

          $grand = $order_details['grand'];
          $grand = ($grand != NULL) ? $grand : 0;

          $grand_total = $grand;
        ?>



<table style="width: 100%;" cellspacing="0" cellpadding="0">
<tr>
<td style="width: 18%;">Customer No:</td>
<td><b>CST <?php echo sprintf('%04d',$customer);?></b></td>
<td style="width: 15%;">Order No:</td>
<td><b>DO|<?php echo sprintf('%06d',$order);?></b></td>
</tr>
<tr>
<td style="width: 18%;">Customer Name:</td>
<td colspan="3"><b><?php echo $customer_name;?></b></td>
</tr>

<tr>
<td style="width: 18%;">Address:</td>
<td><b><?php echo $customer_address;?></b></td>
<td style="width: 15%;">TRN:</td>
<td><b><?php echo $customer_gst;?></b></td>
</tr>

<tr>
<td style="width: 18%;">Phone:</td>
<td><b><?php echo $customer_phone;?></b></td>
<td style="width: 15%;">FAX:</td>
<td><b><?php echo $customer_fax;?></b></td>
</tr>

<tr>
<td style="width: 18%;">Order Date:</td>
<td><b><?php echo $date;?></b></td>
<td style="width: 15%;">JW Number:</td>
<td><b><?php echo $jw;?></b></td>
</tr>

</table>
<br/>
<h3>Order Details</h3>
<br/>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="2">
<tr>
<th style="width: 3%;">#</th>
<th style="width: 14%;">Order No.</th>
<th style="width: 14%;">Item</th>
<th style="width: 14%;">Remark</th>
<th style="width: 9%;">Qty</th>
<th style="width: 8%;">Price</th>
<th style="width: 10%;">Total</th>
</tr>

        <?php
             $sql="SELECT * FROM order_item where order_id = '$order'";
             $query=mysqli_query($conn,$sql);
             $sl=1;
             $subtotal=0;
             while($fetch=mysqli_fetch_array($query))
             {
                  $item = $fetch['item'];
                  $remarkId = $fetch['remark'];
                  $quantity = $fetch['quantity'];
                  $price = $fetch['price'];
                  $total = $fetch['total'];
                  $itemDetails = getItemDetails($item);
                  $remark = getRemarkOfOrderItem($remarkId); 
        ?>
          <tr>
            <td align="center"><?php echo $sl;?></td>
            <td align="center">10012</td>
            <td align="center"><?php echo $itemDetails['name'];?></td>
            <td align="center"><?php echo $remark;?></td>
            <td align="center"><?php echo $quantity;?></td>
            <td align="center"><?php echo $price;?></td>
            <td align="right"><?php echo custom_money_format('%!i', $total);?></td>
          </tr>
        <?php $sl++;} ?>
          <tr>
            <td colspan="6" align="right"><b>Price before GST&nbsp;</b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $sub_total);?></b></td>
          </tr>
          <tr>
            <td colspan="6" align="right"><b>GST&nbsp;5%&nbsp;</b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $vat);?></b></td>
          </tr>
          
          <tr>
            <td colspan="2" align="center"><b>Grand total</b></td>
            <td colspan="4" align="center"><b>
            <?php
              $inwords=ucwords(convert_number_to_words($grand_total));

               if(fmod($grand_total,1)==0)
               {
                 echo 'Rupees '. $inwords." Only";
               }
               else
               {
                $dirham = preg_replace('/ Point.*/', '', $inwords);
                $filsmod1 = fmod($grand_total,1);
                $filsmod = number_format((float)$filsmod1, 2, '.', '');
                $fils = str_replace('0.', '', $filsmod);
                
                echo 'Rupees '. $dirham.' And '.$fils.'/100';
               }
            ?>
            </b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $grand_total);?></b></td>
          </tr>

</table>
<?php
$brv = 16-$sl;
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
