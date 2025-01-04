<?php include "../config.php";?>
<?php
 
$table = 'view_near_period';
$primaryKey = 'cid';
$columns = array(
    array( 'db' => 'cid',  'dt' => 0 ),
    array( 'db' => 'customer',  'dt' => 1 ),
    array( 'db' => 'cust_type',  'dt' => 2 ),
    array( 'db' => 'period',   'dt' => 3 ),
    array( 'db' => 'invo',     'dt' => 4 ),
    array( 'db' => 'date',     'dt' => 5 ),
    array( 'db' => 'ocp',     'dt' => 6 )
);

 
// SQL server connection information

$sql_details = array('user' => $username,'pass' => $password,'db' => $dbname,'host' => $servername);  
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>