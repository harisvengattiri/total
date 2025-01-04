<?php require_once "../database.php";?>

<?php 
$invoice = $_GET["id"]; 
?>
<title>Invoice #<?php echo $invoice;?></title>

<body>
<table style="width: 100%; border:0px">
<tr style="border:0px" >
    <td style="width: 20%; border: 0px"></td>
    <td align="center" style="width: 60%; border: 0px"><h2>TAX INVOICE</h2>
        <h4>TRN 100061540900003</h4>
    </td>
    <td style="width: 20%; border: 0px"></td>
</tr>
</table>
<br/>

     <?php 
        $invoice_details = getInvoiceDetails($invoice);
          $date = $invoice_details['date'];
          $customer = $invoice_details['customer'];
            $customer_details = getCustomerDetails($customer);
              $customer_name = $customer_details['name'];
              $customer_address = $customer_details['address'];
              $customer_phone = $customer_details['phone'];
              $customer_fax = $customer_details['fax'];
              $customer_gst = $customer_details['gst'];
          
          $sub_total = $invoice_details['subtotal'];
          $sub_total = ($sub_total != NULL) ? $sub_total : 0;

          $vat = $invoice_details['vat'];
          $vat = ($vat != NULL) ? $vat : 0;

          $grand = $invoice_details['grand'];
          $grand = ($grand != NULL) ? $grand : 0;
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
<td style="width: 18%;">Invoice Number:</td>
<td><b>INV|<?php echo sprintf('%06d',$invoice);?></b></td>
<td style="width: 15%;">Invoice Date:</td>
<td><b><?php echo $date;?></b></td>
</tr>


</table>
<br/>
<h3>Invoice Details</h3>
<br/>
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="2">
<tr>
<th>#</th>
<th>Item</th>
<th>JW Number</th>
<th>Delivery</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>

        <?php
            $invoice_items = getInvoiceItemDetails($invoice);
            $sl=1;
            foreach($invoice_items as $invoice_item) {
                $item = $invoice_item['item'];
                $jw = $invoice_item['jw'];
                $dn = $invoice_item['dn'];
                $quantity = $invoice_item['quantity'];
                $price = $invoice_item['price'];
                $total = $invoice_item['total'];
                $itemDetails = getItemDetails($item);
        ?>
          <tr>
            <td align="center"><?php echo $sl;?></td>
            <td align="center"><?php echo $itemDetails['name'];?></td>
            <td align="center"><?php echo $jw;?></td>
            <td align="center"><?php echo $dn;?></td>
            <td align="center"><?php echo $quantity;?></td>
            <td align="center"><?php echo $price;?></td>
            <td align="right"><?php echo $total;?></td>
          </tr>
          <?php
            $sl++;}
          ?>
          <tr>
            <td colspan="6" align="right"><b>Sub Total&nbsp;</b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $sub_total); ?></b></td>
          </tr>
          <tr>
            <td colspan="6" align="right"><b>GST Amount&nbsp;</b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $vat); ?></b></td>
          </tr>
          <tr>
            <td colspan="2" align="center"><b>Grand total</b></td>
            <td colspan="4" align="center"><b>
            <?php
              $inwords=ucwords(convert_number_to_words($grand));

               if(fmod($grand,1)==0)
               {
                 echo 'Rupees '. $inwords." Only";
               }
               else
               {
                $dirham = preg_replace('/ Point.*/', '', $inwords);
                $filsmod1 = fmod($grand,1);
                $filsmod = number_format((float)$filsmod1, 2, '.', '');
                $fils = str_replace('0.', '', $filsmod);
                
                echo 'Rupees '. $dirham.' And '.$fils.'/100';
               }
            ?>
            </b></td>
            <td colspan="1" align="right"><b><?php echo custom_money_format('%!i', $grand);?></b></td>
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
