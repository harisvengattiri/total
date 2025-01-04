<?php
require_once "../config.php";
require_once "../database.php";

if (isset($_POST['itemDetails'])) {

    $itemDetails = $_POST['itemDetails'];
    list($item, $JwNumber, $remark) = explode(',', $itemDetails);

    $order = getOrderFromJW($JwNumber);
    $order_balance = getItemDeliveryBalance($order,$item,$remark);

    $sqlOrder = "SELECT `quantity` FROM `order_item` WHERE `order_id`='$order' AND `item`='$item' AND `remark`='$remark'";
    $queryOrder = mysqli_query($conn,$sqlOrder);
    $resultOrder = mysqli_fetch_array($queryOrder);
    $orderQuantity = $resultOrder['quantity'];

    $responseData = array(
        'JwNumber' => $JwNumber,
        'orderQuantity' => $orderQuantity,
        'orderBalance' => $order_balance,
    );
    echo json_encode($responseData);
    exit();
} else {
    echo '<option>Delivery Not Found</option>';
}
