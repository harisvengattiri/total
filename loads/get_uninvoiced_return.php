<?php
require_once "../config.php";

if ($_POST['c_id']) {

    $customer = $_POST['c_id'];
    $sql = "SELECT * FROM `goods_return_note` WHERE `customer`='$customer' AND `invoiced`=0";
    $query = mysqli_query($conn,$sql);
        echo "<option value=''>Select Delivery</option>";
    while($result = mysqli_fetch_array($query)) {
        echo "<option value='{$result['id']}'>GRN|{$result['id']}</option>";
    }
} else {
    echo '<option>Delivery Not Found</option>';
}