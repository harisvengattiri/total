<?php
require_once ('config.php');

// AUTHENTICATION SECTION STARTS

function checkUserExistence($user, $pass) {
    global $conn;

    $username = mysqli_real_escape_string($conn, $user);
    $password = mysqli_real_escape_string($conn, $pass);
    $pwd = md5($password);

    $sql = "select * from users where username='$username' and pwd='$pwd'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception('User with this username and password does not exist');
    }
}

function getUserInfo($user, $password) {
    global $conn;

    $username = mysqli_real_escape_string($conn, $user);
    $password = mysqli_real_escape_string($conn, $password);
    $pwd = md5($password);

    $sql = "select * from users where username='$username' and pwd='$pwd'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception('Unable to fetch user details');
    }
    return $row;
}

function setUserSession($userDetails) {
    session_start();
	$_SESSION["userid"] = $userDetails['id'];
	$_SESSION["username"] = $userDetails['username'];
	$_SESSION["role"] = $userDetails['role'];
	$_SESSION["time"] = time();
}

function trackLoginAttempt($username, $ip_location, $status) {
    global $conn;

    $ip = $_SERVER['REMOTE_ADDR'];
    $now = date("d/m/Y h:i:s a");

    $sql = "INSERT INTO login_log (ip, time, location, username, status) 
            values ('$ip', '$now', '$ip_location', '$username', '$status')";
    $result = $conn->query($sql);
}
// AUTHENTICATION SECTION ENDS

// CUSTOMER SECTION STARTS
function insertCustomer($data) {
    global $conn;

    $sql = "INSERT INTO customers (name,person,address,gst,phone,mobile,fax,email,type,slmn) 
            VALUES ('{$data["name"]}','{$data["person"]}','{$data["address"]}','{$data["gst"]}','{$data["phone"]}','{$data["mobile"]}','{$data["fax"]}','{$data["email"]}','{$data["type"]}','{$data["slmn"]}')";
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','CID',$conn->insert_id,$logQuery);
}

function editCustomer($data) {
    global $conn;

    $sql = "UPDATE `customers` SET `name` = '{$data["name"]}', `person` = '{$data["person"]}', `gst` = '{$data["gst"]}', `address` =  '{$data["address"]}',
            `phone` =  '{$data["phone"]}', `fax` =  '{$data["fax"]}', `mobile` =  '{$data["mobile"]}', `email` =  '{$data["email"]}', `type` =  '{$data["type"]}',
            `slmn` =  '{$data["slmn"]}' WHERE  `id` = {$data["id"]}";
    checkAccountExist('customers','id',$data['id']);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('edit','CID',$data['id'],$logQuery);
}

function deleteCustomer($data) {
    global $conn;

    $sql = "DELETE FROM `customers` WHERE `id` = {$data["id"]}";
    checkAccountExist('customers','id',$data['id']);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','CID',$data['id'],$logQuery);
}

function getCustomerDetails($cid) {
    global $conn;

    $sql = "SELECT * FROM `customers` WHERE `id` = $cid";
    checkAccountExist('customers','id',$cid);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getContactNameFromId($id) {
    global $conn;

    $sql = "SELECT name FROM `customers` WHERE `id` = '$id'";
    checkAccountExist('customers','id',$id);
    $result = $conn->query($sql);
    $fetch = mysqli_fetch_array($result);
    $contact_name = $fetch['name'];
    return $contact_name;
}
// CUSTOMER SECTION ENDS

// ITEMS SECTION STARTS
function getItemsList() {
    global $conn;

    $sql = "SELECT * FROM `items` ORDER BY id DESC LIMIT 0,100";
    $result = $conn->query($sql);
    $items = [];
    while ($row = mysqli_fetch_array($result)) {
        $items[] = $row;
    }
    return $items;
}

function getItemDetails($item) {
    global $conn;

    $sql = "SELECT * FROM `items` WHERE `id` = $item";
    checkAccountExist('items','id',$item);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function insertItem($data) {
    global $conn;

    $sql = "INSERT INTO `items` (`name`,`approx_price`,`cast_weight`,`scrap_weight`,`good_weight`) 
            VALUES ('{$data["name"]}','{$data["approx_price"]}','{$data["cast_weight"]}','{$data["scrap_weight"]}','{$data["good_weight"]}')";
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','ITM',$conn->insert_id,$logQuery);
}

function editItem($data) {
    global $conn;

    $sql = "UPDATE items SET name = '{$data["name"]}',approx_price = '{$data["approx_price"]}',`cast_weight` = '{$data["cast_weight"]}',scrap_weight = '{$data["scrap_weight"]}',
            good_weight = '{$data["good_weight"]}' WHERE id = '{$data["id"]}'";
    checkAccountExist('items','id',$data['id']);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('edit','ITM',$data['id'],$logQuery);
}

function deleteItem($data) {
    global $conn;

    $sql = "DELETE FROM `items` WHERE `id` = {$data["id"]}";
    checkAccountExist('items','id',$data['id']);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','ITM',$data['id'],$logQuery);
}
// ITEMS SECTION ENDS

// VEHICLE SECTION STARTS
function getVehicles() {
    global $conn;

    $sql = "SELECT * FROM `vehicles` ORDER BY id DESC LIMIT 0,100";
    $result = $conn->query($sql);
    $vehicles = [];
    while ($row = mysqli_fetch_array($result)) {
        $vehicles[] = $row;
    }
    return $vehicles;
}

function getVehicleDetails($id) {
    global $conn;

    $sql = "SELECT * FROM `vehicles` WHERE `id` = $id";
    checkAccountExist('vehicles','id',$id);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function addVehicle($data) {
    global $conn;

    $sql = "INSERT INTO `vehicles` (`name`,`registration`) VALUES ('{$data["name"]}','{$data["registration"]}')";
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','VEH',$conn->insert_id,$logQuery);
}

function editVehicle($data) {
    global $conn;
    $vehicle = $data['id'];

    $sql = "UPDATE `vehicles` SET `name`='{$data["name"]}',`registration`='{$data["registration"]}' WHERE `id` = $vehicle";
    checkAccountExist('vehicles','id',$vehicle);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('edit','ITM',$vehicle,$logQuery);
}

function deleteVehicle($data) {
    global $conn;
    $vehicle = $data["id"];

    $sql = "DELETE FROM `vehicles` WHERE `id` = $vehicle";
    checkAccountExist('vehicles','id',$vehicle);
    $conn->query($sql);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','VEH',$vehicle,$logQuery);
}
// VEHICLE SECTION ENDS

// QUOTATION SECTION STARTS
function getQuotationDetails($qn) {
    global $conn;

    $sql = "SELECT * FROM `quotation` WHERE `id` = $qn";
    checkAccountExist('quotation','id',$qn);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getQuotationItemDetails($qn) {
    global $conn;

    $sql = "SELECT * FROM `quotation_item` WHERE `quotation_id` = $qn ORDER BY `id`";
    checkAccountExist('quotation_item','quotation_id',$qn);
    $result = $conn->query($sql);
    $qtn_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $qtn_items[] = $row;
    }
    return $qtn_items;
}

function addQuotation($data) {
    global $conn;

    $sql = "INSERT INTO `quotation` (`customer`, `date`,`attention`,`terms`,`transportation`) 
            VALUES ('{$data["customer"]}','{$data["date"]}','{$data["attention"]}','{$data["terms"]}','{$data["transportation"]}')";
    $conn->query($sql);
    $quotation_id = $conn->insert_id;
        $item = $data["item"];
        $quantity = $data["quantity"];
        $unit = $data["unit"];
        $item_count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
        $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
        $total[$i] = $quantity[$i] * $unit[$i];
        $sql1 = "INSERT INTO `quotation_item` (`quotation_id`, `item`, `quantity`, `price`, `total`) 
                 VALUES ('$quotation_id','$item[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
        $conn->query($sql1);
        $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `quotation` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$quotation_id'";
        $conn->query($sql2);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','QNO',$quotation_id,$logQuery);
}

function editQuotation($data) {
    global $conn;

    $quotation_id = $data["id"];
    $sql = "UPDATE `quotation` SET `customer` =  '{$data["customer"]}', `date` =  '{$data["date"]}', `attention` =  '{$data["attention"]}', `terms` =  '{$data["terms"]}',
            `transportation` =  '{$data["transportation"]}' WHERE `id` = $quotation_id";
    checkAccountExist('quotation','id',$quotation_id);
    $conn->query($sql);
        deleteQuotationItems($quotation_id);
        $item = $data["item"];
        $quantity = $data["quantity"];
        $unit = $data["unit"];

        $count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $item[$i] = mysqli_real_escape_string($conn, $item[$i]);
            $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
            $total[$i] = $quantity[$i] * $unit[$i];
            $sql1 = "INSERT INTO `quotation_item`(`quotation_id`,`item`, `quantity`, `price`, `total`) 
            VALUES ('$quotation_id','$item[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
            $conn->query($sql1);
            $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `quotation` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$quotation_id'";
        $conn->query($sql2);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('edit','QNO',$quotation_id,$logQuery);
}

function deleteQuotation($data) {
    global $conn;
    $quotation_id = $data["id"];

    $sql = "DELETE FROM `quotation` WHERE `id` = $quotation_id";
    checkAccountExist('quotation','id',$quotation_id);
    $conn->query($sql);
    deleteQuotationItems($quotation_id);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','QNO',$quotation_id,$logQuery); 
}

function deleteQuotationItems($qn) {
    global $conn;

    $sql = "DELETE FROM quotation_item WHERE `quotation_id` = $qn";
    $conn->query($sql);
}
// QUOTATION SECTION ENDS

// ORDER SECTION STARTS
function getOrderDetails($ord) {
    global $conn;

    $sql = "SELECT * FROM `sales_order` WHERE `id` = $ord";
    checkAccountExist('sales_order','id',$ord);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getOrderItemDetails($ord) {
    global $conn;

    $sql = "SELECT * FROM `order_item` WHERE `order_id` = $ord ORDER BY `id`";
    checkAccountExist('order_item','order_id',$ord);
    $result = $conn->query($sql);
    $order_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $order_items[] = $row;
    }
    return $order_items;
}

function getOrderFromJW($jw) {
    global $conn;

    $sql = "SELECT id FROM `sales_order` WHERE `jw` = '$jw'";
    checkAccountExist('sales_order','jw',$jw);
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

function addOrder($data) {
    global $conn;

    $sql = "INSERT INTO `sales_order` (`customer`,`token`,`date`,`jw`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["jw"]}')";
    $conn->query($sql);
    $order_id = $conn->insert_id;
        $item = $data["item"];
        $quantity = $data["quantity"];
        $remark = $data["remark"];
        $item_count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            $item_details = getItemDetails($item[$i]);
            $unit[$i] = $item_details['approx_price'];
        $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
        $total[$i] = $quantity[$i] * $unit[$i];
        $sql1 = "INSERT INTO `order_item` (`order_id`, `item`, `remark`, `quantity`, `price`, `total`) 
                 VALUES ('$order_id', '$item[$i]', '$remark[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
        $conn->query($sql1);
        $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `sales_order` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$order_id'";
        $conn->query($sql2);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','DO',$order_id,$logQuery);
}

function editOrder($data) {
    global $conn;

    $order_id = $data["id"];
    
    $sql = "UPDATE `sales_order` SET `customer` =  '{$data["customer"]}', `date` =  '{$data["date"]}', `jw` =  '{$data["jw"]}' WHERE `id` = $order_id";
    checkAccountExist('sales_order','id',$order_id);
    $conn->query($sql);
        deleteOrderItems($order_id);
        $item = $data["item"];
        $quantity = $data["quantity"];
        $remark = $data["remark"];
        $count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $item[$i] = mysqli_real_escape_string($conn, $item[$i]);
            $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
                $item_details = getItemDetails($item[$i]);
                $unit[$i] = $item_details['approx_price'];
            $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
            $total[$i] = $quantity[$i] * $unit[$i];
            $sql1 = "INSERT INTO `order_item`(`order_id`, `item`, `remark`, `quantity`, `price`, `total`) 
            VALUES ('$order_id', '$item[$i]', '$remark[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
            $conn->query($sql1);
            $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `sales_order` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$order_id'";
        $conn->query($sql2);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('edit','DO',$order_id,$logQuery);
}

function deleteOrder($data) {
    global $conn;
    $order_id = $data["id"];

    $sql = "DELETE FROM `sales_order` WHERE `id` = $order_id";
    checkAccountExist('sales_order','id',$order_id);
    $conn->query($sql);
    deleteOrderItems($order_id);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','DO',$order_id,$logQuery);
}

function deleteOrderItems($order_id) {
    global $conn;

    $sql = "DELETE FROM order_item WHERE `order_id` = $order_id";
    $conn->query($sql);
}

function getTotalOrderQuantity($order_id) {
    global $conn;

    $sql = "SELECT SUM(quantity) as TotalOrderQuantity FROM `order_item` WHERE `order_id`='$order_id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['TotalOrderQuantity'];
}

function getTotaldeliverQuantity($id, $type) {
    global $conn;

    $column = ($type === 'order') ? 'order_id' : 'delivery_id';

    $sql = "SELECT SUM(quantity) as TotalDeliverQuantity FROM `delivery_item` WHERE `$column`='$id'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['TotalDeliverQuantity'];
}

function getRemarkOfOrderItem($remark) {
    switch ($remark) {
        case '1':
            $remarkName = 'ROUGH CAST';
            break;
        case '2':
            $remarkName = 'SAMPLE';
            break;
        case '3':
            $remarkName = 'REWORK';
            break;
    }
    return $remarkName;
}
// ORDER SECTION ENDS

// DELIVERY NOTE SECTION STARTS
function getDeliveryDetails($delivery) {
    global $conn;

    $sql = "SELECT * FROM `delivery_note` WHERE `id` = $delivery";
    checkAccountExist('delivery_note','id',$delivery);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getDeliveryItemDetails($delivery) {
    global $conn;

    $sql = "SELECT * FROM `delivery_item` WHERE `delivery_id` = $delivery ORDER BY `id`";
    checkAccountExist('delivery_item','delivery_id',$delivery);
    $result = $conn->query($sql);
    $delivery_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $delivery_items[] = $row;
    }
    return $delivery_items;
}

function addDeliveryNote($data) {
    global $conn;

    $trans = $data["transportation"];
    $jws = $data["jws"];

    $itemDetails = $data["item"];
    $order_quantity = $data["order_quantity"];
    $order_balance = $data["order_balance"];
    $quantity = $data["quantity"];
    $delivery_remark = $data["delivery_item_status"];
    $item_count = sizeof($itemDetails);

    $groupedData = [];
    for ($i = 0; $i < $item_count; $i++) {
        list($item[$i], $jw[$i], $remark[$i]) = explode(',', $itemDetails[$i]);
        groupDelivery($groupedData,$item[$i],$jw[$i],$remark[$i],$order_balance[$i],$quantity[$i]);
    }
    validateDelivery($groupedData);

    $sql = "INSERT INTO `delivery_note` (`customer`,`token`,`date`,`attn`,`transportation`,`vehicle`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["attention"]}','{$data["transportation"]}','{$data["vehicle"]}')";
    $conn->query($sql);
    $delivery_id = $conn->insert_id;
        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            if ($quantity[$i] != 0) {
                list($item[$i], $jw[$i], $remark[$i]) = explode(',', $itemDetails[$i]);
                $item[$i] = mysqli_real_escape_string($conn, $item[$i]);
                    $item_details = getItemDetails($item[$i]);
                    $unit[$i] = $item_details['approx_price'];
                $order[$i] = getOrderFromJW($jw[$i]);
                $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
                $total[$i] = $quantity[$i] * $unit[$i];
                $sql1 = "INSERT INTO `delivery_item` (`delivery_id`, `order_id`, `jw`, `item`, `order_remark`, `delivery_remark`, `quantity`, `price`, `total`) 
                         VALUES ('$delivery_id', '$order[$i]', '$jw[$i]', '$item[$i]', '$remark[$i]', '$delivery_remark[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
                $conn->query($sql1);
                $sum = $sum + $total[$i];
            }
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $grand_total = $trans+$grand;
        $sql2 = "UPDATE `delivery_note` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand', `grand_total`='$grand_total' WHERE id='$delivery_id'";
        $conn->query($sql2);
        checkOrderFlag($jws);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','DN',$delivery_id,$logQuery);
}

function editDeliveryNote($data) {

}

function deleteDeliveryNote($data) {
    global $conn;
    $delivery_id = $data["id"];

    $sql = "DELETE FROM `delivery_note` WHERE `id` = $delivery_id";
    checkAccountExist('delivery_note','id',$delivery_id);
    $conn->query($sql);
    deleteDeliveryItems($delivery_id);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','DN',$delivery_id,$logQuery);
}

function deleteDeliveryItems($delivery_id) {
    global $conn;

    $delivery_item_details = getDeliveryItemDetails($delivery_id);
    foreach ($delivery_item_details as $delivery_item) {
        $order = $delivery_item['order_id'];
        removeOrderflag($order);
    }
    $sql = "DELETE FROM delivery_item WHERE `delivery_id` = $delivery_id";
    $conn->query($sql);
}

function getItemDeliveryBalance($order,$item,$status) {
    global $conn;

    $sql = "SELECT o.quantity - COALESCE(SUM(d.quantity), 0) AS balance
        FROM `order_item` o LEFT JOIN `delivery_item` d ON o.order_id = d.order_id AND o.item = d.item AND o.remark = d.order_remark
        WHERE o.order_id = '$order' AND o.item = '$item' AND o.remark = '$status'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['balance'];
}

function checkOrderFlag($jws) {
    global $conn;

    $jws = explode(',', $jws);

    $order_balance_list = [];
    foreach ($jws as $jw) {
        $order = getOrderFromJW($jw);
        $sql = "SELECT item,remark FROM `order_item` WHERE `order_id`='$order'";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $item = $row['item'];
            $status = $row['remark'];
            $balance = getItemDeliveryBalance($order,$item,$status);
            $order_balance_list[] = [$order,$balance];
        }
    }
    $groupedOrders = [];
    foreach ($order_balance_list as $entry) {
        $order_id = $entry[0];
        $balance = (int) $entry[1];
        if (isset($groupedOrders[$order_id])) {
            $groupedOrders[$order_id] += $balance;
        } else {
            $groupedOrders[$order_id] = $balance;
        }
    }

    foreach ($groupedOrders as $key => $value) {
        if ($value === 0) {
            updateOrderflag($key);
        }
    }
}

function updateOrderflag($order) {
    global $conn;

    $sql = "UPDATE `sales_order` SET `flag` = '1' WHERE `id` = '$order'";
    $conn->query($sql);
}

function removeOrderflag($order) {
    global $conn;

    $sql = "UPDATE `sales_order` SET `flag` = '0' WHERE `id` = '$order'";
    $conn->query($sql);
}

function checkInvoiced($id, $section) {
    global $conn;

    if($section == 'deliveryNotes') {
        $table = 'delivery_note';
    } else if($section == 'goodsReturn') {
        $table = 'goods_return_note';
    }

    $sql = "SELECT `invoiced` FROM `$table` WHERE `id`='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['invoiced'] == 0) {
        return 'No';
    } else {
        return 'Yes';
    }
}

function updateInvoicedInDelivery($delivery,$process) {
    global $conn;

    if($process == 'Add') {
        $invoiced = 1;
    } else if($process == 'Delete') {
        $invoiced = 0;
    }
    $sql = "UPDATE `delivery_note` SET `invoiced` = $invoiced WHERE `id`=$delivery";
    $conn->query($sql);
}

function groupDelivery(&$groupedData,$item,$order,$remark,$order_balance,$quantity) {
    $key = $item . '_' . $order. '_' . $remark;
    if (!isset($groupedData[$key])) {
        $groupedData[$key] = [
            'item' => $item,
            'order' => $order,
            'order_balance' => $order_balance,
            'total_delivered_quantity' => 0,
        ];
    }
    $groupedData[$key]['total_delivered_quantity'] += $quantity;
}

function validateDelivery($groupedData) {
    foreach ($groupedData as $group) {
        if ($group['total_delivered_quantity'] > $group['order_balance']) {
            throw new Exception();
        }
    }  
}

function getRemarkOfdeliveryItem($remark) {
    switch ($remark) {
        case '1':
            $remarkName = '10ᵗʰ 20ᵗʰ 30ᵗʰ OK';
            break;
        case '2':
            $remarkName = '10ᵗʰ 20ᵗʰ 30ᵗʰ OK CD';
            break;
        case '3':
            $remarkName = 'REWORK OK';
            break;
        case '4':
            $remarkName = 'ROUGH CAST';
            break;
        case '5':
            $remarkName = 'REJECTION';
            break;
    }
    return $remarkName;
}
// DELIVERY NOTE SECTION ENDS

// RETURN NOTE SECTION STARTS
function getReturnDetails($returnId) {
    global $conn;

    $sql = "SELECT * FROM `goods_return_note` WHERE `id` = $returnId";
    checkAccountExist('goods_return_note','id',$returnId);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getReturnItemDetails($returnId) {
    global $conn;

    $sql = "SELECT * FROM `goods_return_item` WHERE `return_id` = $returnId ORDER BY `id`";
    checkAccountExist('goods_return_item','return_id',$returnId);
    $result = $conn->query($sql);
    $return_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $return_items[] = $row;
    }
    return $return_items;
}

function addReturnNote($data) {
    global $conn;

    $trans = $data["transportation"];
    $dn = $data["delivery"];

    $itemDetails = $data["item"];
    $jw = $data["jw"];
    $delivery_remark = $data["delivery_remark"];
    $order_remark = $data["order_remark"];
    $delivered_quantity = $data["delivered_quantity"];
    $quantity = $data["quantity"];
    $status = $data["delivery_item_status"];
    $item_count = sizeof($itemDetails);
    $groupedData = [];
    for ($i = 0; $i < $item_count; $i++) {
        list($item[$i], $dID[$i]) = explode(',', $itemDetails[$i]);
        groupDeliveryReturns($groupedData,$item[$i],$jw[$i],$delivery_remark[$i],$order_remark[$i],$delivered_quantity[$i],$quantity[$i]);
    }
    validateDeliveryReturns($groupedData);
    validateItemsWithDelivery($groupedData, $dn);

    $sql = "INSERT INTO `goods_return_note` (`customer`,`token`,`delivery`,`date`,`attn`,`transportation`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$dn}','{$data["date"]}','{$data["attention"]}','{$data["transportation"]}')";
    $conn->query($sql);
    $return_id = $conn->insert_id;

        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            if ($quantity[$i] != 0) {
                list($item[$i], $dID[$i]) = explode(',', $itemDetails[$i]); 

                    $item_details = getItemDetails($item[$i]);
                    $unit[$i] = $item_details['approx_price'];
                    $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
                    $order[$i] = getOrderFromJW($jw[$i]);
                $total[$i] = $quantity[$i] * $unit[$i];

                $sql1 = "INSERT INTO `goods_return_item` (`return_id`, `order_id`, `jw`, `dn`, `item`, `order_remark`, `delivery_remark`, `status`, `quantity`, `price`, `total`) 
                         VALUES ('$return_id', '$order[$i]', '$jw[$i]', '$dn', '$item[$i]', '$order_remark[$i]', '$delivery_remark[$i]', '$status[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
                $conn->query($sql1);
                $sum = $sum + $total[$i];
            }
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $grand_total = $trans+$grand;
        $sql2 = "UPDATE `goods_return_note` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand', `grand_total`='$grand_total' WHERE id='$return_id'";
        $conn->query($sql2);
        updateGoodsReturnInDelivery($dn,'Add');
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','GR',$return_id,$logQuery);
}

function editReturnNote() {

}

function deleteReturnNote($data) {
    global $conn;
    $return_id = $data["id"];
    $dn = getDeliveryFromReturn($return_id);

    $sql = "DELETE FROM `goods_return_note` WHERE `id` = $return_id";
    checkAccountExist('goods_return_note','id',$return_id);
    $conn->query($sql);
    deleteReturnItems($return_id);
    updateGoodsReturnInDelivery($dn,'Remove');
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','GR',$return_id,$logQuery);
}

function deleteReturnItems($return_id) {
    global $conn;

    $sql = "DELETE FROM goods_return_item WHERE `return_id` = '$return_id'";
    $conn->query($sql);
}

function updateGoodsReturnInDelivery($dn,$process) {
    global $conn;

    if($process == 'Add') {
        $grn = '1';
    } else {
        $grn = '0';
    }

    $sql = "UPDATE `delivery_note` SET `GRN`= '$grn' WHERE `id` = '$dn'";
    $conn->query($sql);
}

function getDeliveryFromReturn($return_id) {
    global $conn;

    $sql = "SELECT delivery FROM `goods_return_note` WHERE `id` = '$return_id'";
    checkAccountExist('goods_return_note','id',$return_id);
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['delivery'];
}

function groupDeliveryReturns(&$groupedData,$item,$order,$delivery_remark,$order_remark,$delivered_quantity,$quantity) {
    $key = $item . '_' . $order. '_' . $delivery_remark. '_' . $order_remark;
    if (!isset($groupedData[$key])) {
        $groupedData[$key] = [
            'item' => $item,
            'order' => $order,
            'delivered_quantity' => $delivered_quantity,
            'total_return_quantity' => 0,
        ];
    }
    $groupedData[$key]['total_return_quantity'] += $quantity;
}

function validateDeliveryReturns($groupedData) {
    foreach ($groupedData as $group) {
        if ($group['total_return_quantity'] != $group['delivered_quantity']) {
            throw new Exception();
        }
    }  
}

function validateItemsWithDelivery(&$groupedData, $dn) {
    global $conn;

    $sql = "SELECT COUNT(item) AS delivery_item_count FROM `delivery_item` WHERE `delivery_id`='$dn'";
    $query = $conn->query($sql);
    $result = mysqli_fetch_array($query);
    $delivery_item_count = $result['delivery_item_count'];
    $return_item_count = count($groupedData);

    if($return_item_count != $delivery_item_count) {
        throw new Exception();
    }
}

function getGoodStatusName($status) {
    switch ($status) {
        case '1':
            $stausName = 'ACCEPTED';
            break;
        case '2':
            $stausName = 'REWORK';
            break;
        case '3':
            $stausName = '10ᵗʰ OK';
            break;
        case '4':
            $stausName = '20ᵗʰ OK';
            break;
        case '5':
            $stausName = '30ᵗʰ OK';
            break;
        case '6':
            $stausName = '40ᵗʰ OK';
            break;
        case '7':
            $stausName = 'REWORK';
            break;
        case '8':
            $stausName = 'REJECTION';
            break;
    }
    return $stausName;
}

function updateInvoicedInGRN($return,$process) {
    global $conn;

    if($process == 'Add') {
        $invoiced = 1;
    } else if($process == 'Delete') {
        $invoiced = 0;
    }
    $sql = "UPDATE `goods_return_note` SET `invoiced` = $invoiced WHERE `id`=$return";
    $conn->query($sql);
}
// RETURN NOTE SECTION ENDS

// INVOICE SECTION STARTS
function getInvoiceDetails($invoice) {
    global $conn;
    
    $sql = "SELECT * FROM `invoice` WHERE `id` = $invoice";
    checkAccountExist('invoice','id',$invoice);
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getInvoiceItemDetails($invoice) {
    global $conn;
    
    $sql = "SELECT * FROM `invoice_item` WHERE `invoice_id` = $invoice ORDER BY `id`";
    checkAccountExist('invoice_item','invoice_id',$invoice);
    $result = $conn->query($sql);
    $invoice_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $invoice_items[] = $row;
    }
    return $invoice_items;
}

function addInvoice($data) {
    global $conn;

    $item = $data["item"];
    $gr = $data["gr"];
    $jw = $data["jw"];
    $dq = $data["delivered_quantity"];
    $price = $data["price"];
    $item_count = sizeof($item);
    // $groupedData = [];
    // for ($i = 0; $i < $item_count; $i++) {
    //     list($item[$i], $jw[$i]) = explode(',', $itemDetails[$i]);
    //     groupDeliveryReturns($groupedData,$item[$i],$jw[$i],$delivered_quantity[$i],$quantity[$i]);
    // }
    // validateDeliveryReturns($groupedData);

    $sql = "INSERT INTO `invoice` (`customer`,`token`,`date`,`attn`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["attention"]}')";
    $conn->query($sql);
    $invoice_id = $conn->insert_id;

        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $dq[$i] = ($dq[$i] != NULL) ? $dq[$i] : 0;
            if ($dq[$i] != 0) {

                $order[$i] = getOrderFromJW($jw[$i]);
                $dn[$i] = getDeliveryFromReturn($gr[$i]);
                $total[$i] = $dq[$i] * $price[$i];

                $sql1 = "INSERT INTO `invoice_item` (`invoice_id`, `order_id`, `jw`, `dn`, `gr`, `item`, `quantity`, `price`, `total`) 
                         VALUES ('$invoice_id', '$order[$i]', '$jw[$i]', '$dn[$i]', '$gr[$i]', '$item[$i]', '$dq[$i]', '$price[$i]', '$total[$i]')";
                $conn->query($sql1);
                $sum = $sum + $total[$i];
                // updateInvoicedInDelivery($dn[$i],'Add');
                // updateInvoicedInGRN($gr[$i],'Add');
            }
        }
        
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `invoice` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand' WHERE id='$invoice_id'";
        $conn->query($sql2);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('add','INV',$invoice_id,$logQuery);
}

function editInvoice() {

}

function deleteInvoice($data) {
    global $conn;
    $invoice_id = $data["id"];

    $sql = "DELETE FROM `invoice` WHERE `id` = $invoice_id";
    checkAccountExist('invoice','id',$invoice_id);
    $conn->query($sql);
    deleteInvoiceItems($invoice_id);
    $logQuery = mysqli_real_escape_string($conn,$sql);
    logActivity('delete','INV',$invoice_id,$logQuery);
}

function deleteInvoiceItems($invoice_id) {
    global $conn;

    $invoice_itemDetails = getInvoiceItemDetails($invoice_id);
    foreach($invoice_itemDetails as $invoice_item) {
        $dn = $invoice_item['dn'];
        $gr = $invoice_item['gr'];

        updateInvoicedInDelivery($dn,'Delete');
        updateInvoicedInGRN($gr,'Delete');
    }
    $sql = "DELETE FROM invoice_item WHERE `invoice_id` = '$invoice_id'";
    $conn->query($sql);
}
// INVOICE SECTION ENDS

// ACTIVITY LOG SECTION STARTS
function logActivity($process,$code,$id,$logQuery) {
    global $conn;
    
    $date1 = date("d/m/Y h:i:s a");
    $username = $_SESSION['username'];
    $code = $code.$id;
    $logSql = "INSERT INTO activity_log (time, process, code, user, query) 
               VALUES ('$date1', '$process', '$code', '$username', '$logQuery')";
    $conn->query($logSql);
}
// ACTIVITY LOG SECTION ENDS

// CHECK EXISTANCE FOR EDIT AND DELETE
function checkAccountExist($table,$column,$id) {
    global $conn;

    $sqlIdCheck = "SELECT * FROM `$table` WHERE `$column` = '$id'";
    $query = $conn->query($sqlIdCheck);
    $num_rows = mysqli_num_rows($query);

    if(!$num_rows) {
        throw new Exception();
    }
}

// SEARCH FILTER SECTION
function getSearchFilters() {
    $period_sql = "";
    $cust_sql = "";
    $mode = 'Recent View';
    $show_date = "";

    if ($_POST) {
        $fdate = $_POST['fdate'];
        $tdate = $_POST['tdate'];
        $customer = $_POST['customer'];

        $period_sql = "WHERE STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN STR_TO_DATE('$fdate', '%d/%m/%Y') AND STR_TO_DATE('$tdate', '%d/%m/%Y')";
        if (!empty($customer)) {
            $cust_sql = "AND `customer` = '$customer'";
        }
        $mode = 'Search Mode';
        $show_date = "[$fdate - $tdate]";
    }
    return [
        'period_sql' => $period_sql,
        'cust_sql' => $cust_sql,
        'mode' => $mode,
        'show_date' => $show_date
    ];
}
