<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/total/includes/functions_inc.php');

loadEnv(__DIR__.'/.env');

$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_DATABASE');

define('BASEURL', getenv('BASEURL'));
define('CDNURL', BASEURL.'/cdn/pdf');

$title = "CERP | TOTAL ENGINEERING - "
.ucwords(str_ireplace(array(BASEURL,'.php', '_', 'index', '/'), array('', '', ' ', 'dashboard', ' '), 'https://'.$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));
$erp_version="Version 2.1.6";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
