<?php
require_once "../config.php";

if ($_POST['c_id']) {

    $customer = $_POST['c_id'];
    $sql = "SELECT * FROM `delivery_note` WHERE `customer`='$customer' AND `GRN`=0";
    $query = mysqli_query($conn,$sql);
        echo "<option value=''>Select Delivery</option>";
    while($result = mysqli_fetch_array($query)) {
        echo "<option value='{$result['id']}'>DN|{$result['id']}</option>";
    }
} else {
    echo '<option>Delivery Not Found</option>';
}