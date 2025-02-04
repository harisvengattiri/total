<?php
require_once ('config.php');

// SOME COMMONLY USED FUNCTIONS STARTS
function prepareInsertQuery($table, $data) {
    $columns = generateColumnsFromKeys($data);
    $entrys = generateEntryFromValues($data);
    return "INSERT INTO $table ($columns) VALUES ($entrys)";
}
function insert($table, $data) {
    getConnection()->query(prepareInsertQuery($table, $data));
}
function prepareEditQuery($table, $data) {
    $columnValues = '';
    foreach($data as $key => $value) {
        $columnValues .= "'$key' = '$value', ";
    }
    $columnValues = rtrim($columnValues, ', ');
    return "UPDATE $table SET $columnValues WHERE `id`={$data['id']}";
}
function edit($table, $data) {
    getConnection()->query(prepareEditQuery($table, $data));
}
function prepareDeleteQuery($table, $id) {
    return "DELETE FROM `$table` WHERE `id` = {$id}";
}
function delete($table, $id) {
    getConnection()->query(prepareDeleteQuery($table, $id));
}
function prepareGetDetailQuery($table, $id) {
    return "SELECT * FROM `$table` WHERE `id` = $id";
}
function getDetails($table, $id) {
    checkAccountExist($table, 'id', $id);
    $result = getConnection()->query(prepareGetDetailQuery($table, $id));
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}
function getList($table) {
    $sql = "SELECT * FROM `$table` ORDER BY id DESC LIMIT 0,100";
    $result = getConnection()->query($sql);
    $list = [];
    while ($row = mysqli_fetch_array($result)) {
        $list[] = $row;
    }
    return $list;
}
function getItemsById($table, $feild, $id) {
    $sql = "SELECT * FROM `$table` WHERE `$feild` = '$id'";
    checkAccountExist($table, $feild, $id);
    $result = getConnection()->query($sql);
    $items = [];
    while ($row = mysqli_fetch_array($result)) {
        $items[] = $row;
    }
    return $items;
}
function generateColumnsFromKeys($data) {
    return implode(',', generateKeysFromData($data));
}
function generateEntryFromValues($data) {
    return implode(',', generateValuesFromData($data));
}
function generateKeysFromData($data) {
    return array_keys($data);
}
function generateValuesFromData($data) {
    return array_values($data);
}
function getInsertId() {
    return getConnection()->insert_id;
}
function prepareLogQuery($sql) {
    return escapeString($sql);
}
// SOME COMMONLY USED FUNCTIONS ENDS

// AUTHENTICATION SECTION STARTS
function getConnection() {
    return mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));
}
function escapeString($string) {
    return mysqli_real_escape_string(getConnection(), $string);
}
function hashPassword($password) {
    return md5($password);  
}
function prepareUserQuery($user, $pass) {
    $username = escapeString($user);
    $pwd = escapeString(hashPassword($pass));
    return "SELECT * FROM `users` WHERE `username`='$username' AND `pwd`='$pwd'";
}
function checkUserExistence($user, $pass) {
    $result = mysqli_query(getConnection(), prepareUserQuery($user, $pass));
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception('User with this username and password does not exist');
    }
}
function getUserInfo($user, $password) {
    $result = mysqli_query(getConnection(), prepareUserQuery($user, $password));
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
function trackLoginAttempt($username, $status) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ip_location = findMyIPDetails();  
    $now = date("d/m/Y h:i:s a");

    $sql = "INSERT INTO login_log (ip, time, location, username, status) 
            values ('$ip', '$now', '$ip_location', '$username', '$status')";
    getConnection()->query($sql);
}
// AUTHENTICATION SECTION ENDS

// CUSTOMER SECTION STARTS
function insertCustomer($table, $data) {
    insert($table, $data);
    logActivity('add','CID',getInsertId(),prepareLogQuery(prepareInsertQuery($table, $data)));
}
function deleteCustomer($id) {
    checkAccountExist('customers','id',$id);
    delete('customers', $id);
    logActivity('delete','CID',$id,escapeString(prepareDeleteQuery('customers', $id)));
}
function getCustomerDetails($id) {
    getDetails('customers', $id);
}
function editCustomer($data) {
    checkAccountExist('customers','id',$data['id']);
    edit('customers', $data);
    logActivity('edit','CID',$data['id'],escapeString(prepareEditQuery('customers', $data)));
}
function getContactNameFromId($id) {
    $sql = "SELECT name FROM `customers` WHERE `id` = '$id'";
    checkAccountExist('customers','id',$id);
    $result = getConnection()->query($sql);
    $fetch = mysqli_fetch_array($result);
    $contact_name = $fetch['name'];
    return $contact_name;
}
// CUSTOMER SECTION ENDS

// ITEMS SECTION STARTS
function getItemsList() {
    getList('items'); 
}
function getItemDetails($item) {
    getDetails('items', $item);
}
function insertItem($data) {
    insert('items', $data);
    logActivity('add','ITM',getInsertId(),prepareLogQuery(prepareInsertQuery('items', $data)));
}
function editItem($data) {
    checkAccountExist('items','id',$data['id']);
    edit('items', $data);
    logActivity('edit','ITM',$data['id'],escapeString(prepareEditQuery('items', $data)));
}
function deleteItem($data) {
    checkAccountExist('items','id',$data['id']);
    delete('items', $data['id']);
    logActivity('delete','ITM',$data['id'],escapeString(prepareDeleteQuery('items', $data['id'])));
}
// ITEMS SECTION ENDS

// VEHICLE SECTION STARTS
function getVehicles() {
    getList('vehicles');
}
function getVehicleDetails($id) {
    getDetails('vehicles', $id);
}
function addVehicle($data) {
    insert('vehicles', $data);
    logActivity('add','VEH',getInsertId(),prepareLogQuery(prepareInsertQuery('vehicles', $data)));
}
function editVehicle($data) {
    checkAccountExist('vehicles','id',$data['id']);
    edit('vehicles', $data);
    logActivity('edit','VEH',$data['id'],escapeString(prepareEditQuery('vehicles', $data)));
}
function deleteVehicle($data) {
    checkAccountExist('vehicles','id',$data['id']);
    delete('vehicles', $data['id']);
    logActivity('delete','VEH',$data['id'],escapeString(prepareDeleteQuery('vehicles', $data['id'])));
}
// VEHICLE SECTION ENDS

// QUOTATION SECTION STARTS
function getQuotationDetails($qn) {
    getDetails('quotation', $qn);
}
function getQuotationItemDetails($qn) {
    getItemsById('quotation_item', 'quotation_id', $qn);
}
function addQuotation($data) {
    insert('quotation', $data);
    $quotation_id = getConnection()->insert_id;
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
        getConnection()->query($sql1);
        $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `quotation` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$quotation_id'";
        getConnection()->query($sql2);
    logActivity('add','QNO',getInsertId(),escapeString(prepareInsertQuery('quotation', $data)));
}

function editQuotation($data) {

    checkAccountExist('quotation','id',$data['id']);
    edit('quotation', $data);

    $quotation_id = $data["id"];
        deleteQuotationItems($quotation_id);
        $item = $data["item"];
        $quantity = $data["quantity"];
        $unit = $data["unit"];

        $count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $item[$i] = mysqli_real_escape_string(getConnection(), $item[$i]);
            $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
            $total[$i] = $quantity[$i] * $unit[$i];
            $sql1 = "INSERT INTO `quotation_item`(`quotation_id`,`item`, `quantity`, `price`, `total`) 
            VALUES ('$quotation_id','$item[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
            getConnection()->query($sql1);
            $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `quotation` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$quotation_id'";
        getConnection()->query($sql2);
    logActivity('edit','QNO',$data['id'],escapeString(prepareEditQuery('quotation', $data)));
}

function deleteQuotation($data) {
    $quotation_id = $data["id"];

    $sql = "DELETE FROM `quotation` WHERE `id` = $quotation_id";
    checkAccountExist('quotation','id',$quotation_id);
    getConnection()->query($sql);
    deleteQuotationItems($quotation_id);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('delete','QNO',$quotation_id,$logQuery); 
}

function deleteQuotationItems($qn) {
    $sql = "DELETE FROM quotation_item WHERE `quotation_id` = $qn";
    getConnection()->query($sql);
}
// QUOTATION SECTION ENDS

// ORDER SECTION STARTS
function getOrderDetails($ord) {
    $sql = "SELECT * FROM `sales_order` WHERE `id` = $ord";
    checkAccountExist('sales_order','id',$ord);
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getOrderItemDetails($ord) {
    $sql = "SELECT * FROM `order_item` WHERE `order_id` = $ord ORDER BY `id`";
    checkAccountExist('order_item','order_id',$ord);
    $result = getConnection()->query($sql);
    $order_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $order_items[] = $row;
    }
    return $order_items;
}

function getOrderFromJW($jw) {
    $sql = "SELECT id FROM `sales_order` WHERE `jw` = '$jw'";
    checkAccountExist('sales_order','jw',$jw);
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['id'];
}

function addOrder($data) {
    $sql = "INSERT INTO `sales_order` (`customer`,`token`,`date`,`jw`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["jw"]}')";
    getConnection()->query($sql);
    $order_id = getConnection()->insert_id;
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
        getConnection()->query($sql1);
        $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `sales_order` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$order_id'";
        getConnection()->query($sql2);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('add','DO',$order_id,$logQuery);
}

function editOrder($data) {
    $order_id = $data["id"];
    
    $sql = "UPDATE `sales_order` SET `customer` =  '{$data["customer"]}', `date` =  '{$data["date"]}', `jw` =  '{$data["jw"]}' WHERE `id` = $order_id";
    checkAccountExist('sales_order','id',$order_id);
    getConnection()->query($sql);
        deleteOrderItems($order_id);
        $item = $data["item"];
        $quantity = $data["quantity"];
        $remark = $data["remark"];
        $count = sizeof($item);
        $sum = 0;
        for ($i = 0; $i < $count; $i++) {
            $item[$i] = mysqli_real_escape_string(getConnection(), $item[$i]);
            $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
                $item_details = getItemDetails($item[$i]);
                $unit[$i] = $item_details['approx_price'];
            $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
            $total[$i] = $quantity[$i] * $unit[$i];
            $sql1 = "INSERT INTO `order_item`(`order_id`, `item`, `remark`, `quantity`, `price`, `total`) 
            VALUES ('$order_id', '$item[$i]', '$remark[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
            getConnection()->query($sql1);
            $sum = $sum + $total[$i];
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `sales_order` SET `subtotal`='$sum',`vat`='$vat',`grand`='$grand' WHERE id='$order_id'";
        getConnection()->query($sql2);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('edit','DO',$order_id,$logQuery);
}

function deleteOrder($data) {
    $order_id = $data["id"];

    $sql = "DELETE FROM `sales_order` WHERE `id` = $order_id";
    checkAccountExist('sales_order','id',$order_id);
    getConnection()->query($sql);
    deleteOrderItems($order_id);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('delete','DO',$order_id,$logQuery);
}

function deleteOrderItems($order_id) {
    $sql = "DELETE FROM order_item WHERE `order_id` = $order_id";
    getConnection()->query($sql);
}

function getTotalOrderQuantity($order_id) {
    $sql = "SELECT SUM(quantity) as TotalOrderQuantity FROM `order_item` WHERE `order_id`='$order_id'";
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_array($result);
    return $row['TotalOrderQuantity'];
}

function getTotaldeliverQuantity($id, $type) {
    $column = ($type === 'order') ? 'order_id' : 'delivery_id';

    $sql = "SELECT SUM(quantity) as TotalDeliverQuantity FROM `delivery_item` WHERE `$column`='$id'";
    $result = getConnection()->query($sql);
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
    $sql = "SELECT * FROM `delivery_note` WHERE `id` = $delivery";
    checkAccountExist('delivery_note','id',$delivery);
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getDeliveryItemDetails($delivery) {
    $sql = "SELECT * FROM `delivery_item` WHERE `delivery_id` = $delivery ORDER BY `id`";
    checkAccountExist('delivery_item','delivery_id',$delivery);
    $result = getConnection()->query($sql);
    $delivery_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $delivery_items[] = $row;
    }
    return $delivery_items;
}

function addDeliveryNote($data) {
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
        $groupedData = groupDelivery($groupedData,$item[$i],$jw[$i],$remark[$i],$order_balance[$i],$quantity[$i]);
    }
    validateDelivery($groupedData);

    $sql = "INSERT INTO `delivery_note` (`customer`,`token`,`date`,`attn`,`transportation`,`vehicle`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["attention"]}','{$data["transportation"]}','{$data["vehicle"]}')";
    getConnection()->query($sql);
    $delivery_id = getConnection()->insert_id;
        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $quantity[$i] = ($quantity[$i] != NULL) ? $quantity[$i] : 0;
            if ($quantity[$i] != 0) {
                list($item[$i], $jw[$i], $remark[$i]) = explode(',', $itemDetails[$i]);
                $item[$i] = mysqli_real_escape_string(getConnection(), $item[$i]);
                    $item_details = getItemDetails($item[$i]);
                    $unit[$i] = $item_details['approx_price'];
                $order[$i] = getOrderFromJW($jw[$i]);
                $unit[$i] = ($unit[$i] != NULL) ? $unit[$i] : 0;
                $total[$i] = $quantity[$i] * $unit[$i];
                $sql1 = "INSERT INTO `delivery_item` (`delivery_id`, `order_id`, `jw`, `item`, `order_remark`, `delivery_remark`, `quantity`, `price`, `total`) 
                         VALUES ('$delivery_id', '$order[$i]', '$jw[$i]', '$item[$i]', '$remark[$i]', '$delivery_remark[$i]', '$quantity[$i]', '$unit[$i]', '$total[$i]')";
                getConnection()->query($sql1);
                $sum = $sum + $total[$i];
            }
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $grand_total = $trans+$grand;
        $sql2 = "UPDATE `delivery_note` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand', `grand_total`='$grand_total' WHERE id='$delivery_id'";
        getConnection()->query($sql2);
        checkOrderFlag($jws);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('add','DN',$delivery_id,$logQuery);
}

function editDeliveryNote($data) {

}

function deleteDeliveryNote($data) {
    $delivery_id = $data["id"];

    $sql = "DELETE FROM `delivery_note` WHERE `id` = $delivery_id";
    checkAccountExist('delivery_note','id',$delivery_id);
    getConnection()->query($sql);
    deleteDeliveryItems($delivery_id);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('delete','DN',$delivery_id,$logQuery);
}

function deleteDeliveryItems($delivery_id) {
    $delivery_item_details = getDeliveryItemDetails($delivery_id);
    foreach ($delivery_item_details as $delivery_item) {
        $order = $delivery_item['order_id'];
        removeOrderflag($order);
    }
    $sql = "DELETE FROM delivery_item WHERE `delivery_id` = $delivery_id";
    getConnection()->query($sql);
}

function getItemDeliveryBalance($order,$item,$status) {
    $sql = "SELECT o.quantity - COALESCE(SUM(d.quantity), 0) AS balance
        FROM `order_item` o LEFT JOIN `delivery_item` d ON o.order_id = d.order_id AND o.item = d.item AND o.remark = d.order_remark
        WHERE o.order_id = '$order' AND o.item = '$item' AND o.remark = '$status'";
    $result = mysqli_query(getConnection(), $sql);
    $row = mysqli_fetch_assoc($result);

    return $row['balance'];
}

function checkOrderFlag($jws) {
    $jws = explode(',', $jws);

    $order_balance_list = [];
    foreach ($jws as $jw) {
        $order = getOrderFromJW($jw);
        $sql = "SELECT item,remark FROM `order_item` WHERE `order_id`='$order'";
        $result = mysqli_query(getConnection(), $sql);
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
    $sql = "UPDATE `sales_order` SET `flag` = '1' WHERE `id` = '$order'";
    getConnection()->query($sql);
}

function removeOrderflag($order) {
    $sql = "UPDATE `sales_order` SET `flag` = '0' WHERE `id` = '$order'";
    getConnection()->query($sql);
}

function checkInvoiced($id, $section) {
    if($section == 'deliveryNotes') {
        $table = 'delivery_note';
    } else if($section == 'goodsReturn') {
        $table = 'goods_return_note';
    }

    $sql = "SELECT `invoiced` FROM `$table` WHERE `id`='$id'";
    $result = mysqli_query(getConnection(), $sql);
    $row = mysqli_fetch_assoc($result);
    if($row['invoiced'] == 0) {
        return 'No';
    } else {
        return 'Yes';
    }
}

function updateInvoicedInDelivery($delivery,$process) {
    if($process == 'Add') {
        $invoiced = 1;
    } else if($process == 'Delete') {
        $invoiced = 0;
    }
    $sql = "UPDATE `delivery_note` SET `invoiced` = $invoiced WHERE `id`=$delivery";
    getConnection()->query($sql);
}

function groupDelivery($groupedData,$item,$order,$remark,$order_balance,$quantity) {
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
    return $groupedData;
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
    $sql = "SELECT * FROM `goods_return_note` WHERE `id` = $returnId";
    checkAccountExist('goods_return_note','id',$returnId);
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getReturnItemDetails($returnId) {
    $sql = "SELECT * FROM `goods_return_item` WHERE `return_id` = $returnId ORDER BY `id`";
    checkAccountExist('goods_return_item','return_id',$returnId);
    $result = getConnection()->query($sql);
    $return_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $return_items[] = $row;
    }
    return $return_items;
}

function addReturnNote($data) {
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
    getConnection()->query($sql);
    $return_id = getConnection()->insert_id;

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
                getConnection()->query($sql1);
                $sum = $sum + $total[$i];
            }
        }
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $grand_total = $trans+$grand;
        $sql2 = "UPDATE `goods_return_note` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand', `grand_total`='$grand_total' WHERE id='$return_id'";
        getConnection()->query($sql2);
        updateGoodsReturnInDelivery($dn,'Add');
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('add','GR',$return_id,$logQuery);
}

function editReturnNote() {

}

function deleteReturnNote($data) {
    $return_id = $data["id"];
    $dn = getDeliveryFromReturn($return_id);

    $sql = "DELETE FROM `goods_return_note` WHERE `id` = $return_id";
    checkAccountExist('goods_return_note','id',$return_id);
    getConnection()->query($sql);
    deleteReturnItems($return_id);
    updateGoodsReturnInDelivery($dn,'Remove');
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('delete','GR',$return_id,$logQuery);
}

function deleteReturnItems($return_id) {
    $sql = "DELETE FROM goods_return_item WHERE `return_id` = '$return_id'";
    getConnection()->query($sql);
}

function updateGoodsReturnInDelivery($dn,$process) {
    if($process == 'Add') {
        $grn = '1';
    } else {
        $grn = '0';
    }

    $sql = "UPDATE `delivery_note` SET `GRN`= '$grn' WHERE `id` = '$dn'";
    getConnection()->query($sql);
}

function getDeliveryFromReturn($return_id) {
    $sql = "SELECT delivery FROM `goods_return_note` WHERE `id` = '$return_id'";
    checkAccountExist('goods_return_note','id',$return_id);
    $result = getConnection()->query($sql);
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
    $sql = "SELECT COUNT(item) AS delivery_item_count FROM `delivery_item` WHERE `delivery_id`='$dn'";
    $query = getConnection()->query($sql);
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
    if($process == 'Add') {
        $invoiced = 1;
    } else if($process == 'Delete') {
        $invoiced = 0;
    }
    $sql = "UPDATE `goods_return_note` SET `invoiced` = $invoiced WHERE `id`=$return";
    getConnection()->query($sql);
}
// RETURN NOTE SECTION ENDS

// INVOICE SECTION STARTS
function getInvoiceDetails($invoice) {
    $sql = "SELECT * FROM `invoice` WHERE `id` = $invoice";
    checkAccountExist('invoice','id',$invoice);
    $result = getConnection()->query($sql);
    $row = mysqli_fetch_assoc($result);
    if(!$row) {
        throw new Exception();
    }
    return $row;
}

function getInvoiceItemDetails($invoice) {
    $sql = "SELECT * FROM `invoice_item` WHERE `invoice_id` = $invoice ORDER BY `id`";
    checkAccountExist('invoice_item','invoice_id',$invoice);
    $result = getConnection()->query($sql);
    $invoice_items = [];
    while ($row = mysqli_fetch_array($result)) {
        $invoice_items[] = $row;
    }
    return $invoice_items;
}

function addInvoice($data) {
    $item = $data["item"];
    $gr = $data["gr"];
    $jw = $data["jw"];
    $dq = $data["delivered_quantity"];
    $price = $data["price"];
    $item_count = sizeof($item);

    $sql = "INSERT INTO `invoice` (`customer`,`token`,`date`,`attn`)
            VALUES ('{$data["customer"]}','{$data["token"]}','{$data["date"]}','{$data["attention"]}')";
    getConnection()->query($sql);
    $invoice_id = getConnection()->insert_id;

        $sum = 0;
        for ($i = 0; $i < $item_count; $i++) {
        $dq[$i] = ($dq[$i] != NULL) ? $dq[$i] : 0;
            if ($dq[$i] != 0) {

                $order[$i] = getOrderFromJW($jw[$i]);
                $dn[$i] = getDeliveryFromReturn($gr[$i]);
                $total[$i] = $dq[$i] * $price[$i];

                $sql1 = "INSERT INTO `invoice_item` (`invoice_id`, `order_id`, `jw`, `dn`, `gr`, `item`, `quantity`, `price`, `total`) 
                         VALUES ('$invoice_id', '$order[$i]', '$jw[$i]', '$dn[$i]', '$gr[$i]', '$item[$i]', '$dq[$i]', '$price[$i]', '$total[$i]')";
                getConnection()->query($sql1);
                $sum = $sum + $total[$i];
            }
        }
        
        $vat = $sum*0.05;
        $grand = $sum*1.05;
        $sql2 = "UPDATE `invoice` SET `subtotal`='$sum', `vat`='$vat', `grand`='$grand' WHERE id='$invoice_id'";
        getConnection()->query($sql2);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('add','INV',$invoice_id,$logQuery);
}

function editInvoice() {

}

function deleteInvoice($data) {
    $invoice_id = $data["id"];

    $sql = "DELETE FROM `invoice` WHERE `id` = $invoice_id";
    checkAccountExist('invoice','id',$invoice_id);
    getConnection()->query($sql);
    deleteInvoiceItems($invoice_id);
    $logQuery = mysqli_real_escape_string(getConnection(),$sql);
    logActivity('delete','INV',$invoice_id,$logQuery);
}

function deleteInvoiceItems($invoice_id) {
    $invoice_itemDetails = getInvoiceItemDetails($invoice_id);
    foreach($invoice_itemDetails as $invoice_item) {
        $dn = $invoice_item['dn'];
        $gr = $invoice_item['gr'];

        updateInvoicedInDelivery($dn,'Delete');
        updateInvoicedInGRN($gr,'Delete');
    }
    $sql = "DELETE FROM invoice_item WHERE `invoice_id` = '$invoice_id'";
    getConnection()->query($sql);
}
// INVOICE SECTION ENDS

// ACTIVITY LOG SECTION STARTS
function logActivity($process,$code,$id,$logQuery) {
    $date1 = date("d/m/Y h:i:s a");
    $username = $_SESSION['username'];
    $code = $code.$id;
    $logSql = "INSERT INTO activity_log (time, process, code, user, query) 
               VALUES ('$date1', '$process', '$code', '$username', '$logQuery')";
    getConnection()->query($logSql);
}
// ACTIVITY LOG SECTION ENDS

// CHECK EXISTANCE FOR EDIT AND DELETE
function checkAccountExist($table,$column,$id) {
    $sqlIdCheck = "SELECT * FROM `$table` WHERE `$column` = '$id'";
    $query = getConnection()->query($sqlIdCheck);
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
