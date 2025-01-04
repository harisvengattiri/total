<?php

$con = mysqli_connect("localhost","gulfzyym_mancon","]fCccA1%XA%#","gulfzyym_mancon");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Get thread id
$t_id=mysqli_thread_id($con);

// Kill connection
mysqli_kill($con, $t_id);

mysqli_close($con);
?>