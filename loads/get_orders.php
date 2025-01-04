<?php
require_once "../config.php";

if ($_POST['c_id']) {

    $customer = $_POST['c_id'];
    $sql = "SELECT id,jw FROM `sales_order` WHERE `customer`='$customer' AND `flag`=0";
    $query = mysqli_query($conn,$sql);
    while($result = mysqli_fetch_array($query)) {
        $so = $result['id'];
        $jw = $result['jw'];
        $sql1 = "SELECT itm.name AS itemName FROM order_item soi INNER JOIN items itm ON soi.item=itm.id
                 WHERE soi.order_id=$so";
        $query1 = mysqli_query($conn,$sql1);
        $itemNames = [];
        while($result1 = mysqli_fetch_array($query1)) {
            $itemSubName = substr($result1['itemName'], 0, 7);
            $itemNames[] = $itemSubName;
        }
        $itemNamesString = implode(", ", $itemNames);
        echo "<option value='{$jw}'>JW|{$jw} - [{$itemNamesString}]</option>";
    }
} else {
    echo '<option>Order Not Found</option>';
}