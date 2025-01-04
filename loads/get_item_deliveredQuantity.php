<?php
require_once "../config.php";

if (isset($_POST['itemDetails'])) {

    $itemDetails = $_POST['itemDetails'];

    list($item, $dID) = explode(',', $itemDetails);

    $sql = "SELECT quantity,jw,delivery_remark,order_remark FROM `delivery_item` WHERE `id`='$dID' AND `item`='$item'";
    $query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($query);
    $delivered_quantity = $result['quantity'];
    $JwNumber = $result['jw'];
    $delivery_remark = $result['delivery_remark'];
    $order_remark = $result['order_remark'];

    $responseData = array(
        'JwNumber' => $JwNumber,
        'deliveredQuantity' => $delivered_quantity,
        'deliveryRemark' => $delivery_remark,
        'orderRemark' => $order_remark,
    );
    echo json_encode($responseData);
    exit();
} else {
    echo '<option>Delivery Not Found</option>';
}
