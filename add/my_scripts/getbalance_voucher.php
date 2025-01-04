<?php
include "../../config.php";
if(isset($_POST['c_id'])){
   
   $staff = $_POST['c_id'];
   
   $sql = "SELECT sum(amount) AS amount FROM petty_voucher WHERE staff='$staff' AND status='Cleared'";
   $query = mysqli_query($conn,$sql);
   $result = mysqli_fetch_array($query);
   $amount = $result['amount'];

   $sql1 = "SELECT sum(total) AS total FROM petty_cash WHERE staff='$staff'";
   $query1 = mysqli_query($conn,$sql1);
   $result1 = mysqli_fetch_array($query1);
   $total = $result1['total'];
   
   $balance = $amount-$total;
   
//   if($balance > 0){
       echo number_format($balance, 2, '.', '');
    //   }
}
?>