<?php
require_once "../config.php";
require_once "../database.php";

if (isset($_POST['grItem'])) {

    $grItemID = $_POST['grItem'];

    $sql = "SELECT * FROM `goods_return_item` WHERE `id`='$grItemID'";
    $query = mysqli_query($conn,$sql);
    $result = mysqli_fetch_array($query);
    $item = $result['item'];
    $return = $result['return_id'];
    $JwNumber = $result['jw'];
    $delivered_quantity = $result['quantity'];
        $itemDetails = getItemDetails($item);
        $price = $itemDetails['approx_price'];

    $responseData = array(
        'Item' => $item,
        'JwNumber' => $JwNumber,
        'deliveredQuantity' => $delivered_quantity,
        'returnId' => $return,
        'price' => $price,
    );
    echo json_encode($responseData);
    exit();
} else {
    echo '<option>Delivery Not Found</option>';
}
