<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Webpage</title>
<style>
.preloader {
    /* Your preloader styles here */
}
.loader {
    /* Your preloader GIF styles here */
}
.content {
    display: none;
}
</style>
</head>

<body>
    <!-- Preloader Container -->
    <div class="preloader">
        <img src="loading.gif" alt="Loading..." class="loader">
    </div>

    <!-- Main Content -->
    <div class="content">
    <?php
    include "../../config.php";
    // finding receivables
    
    $fdate = '01/07/2023';
    $tdate = '12/09/2023';

    $sqlReceivables = "SELECT `invoice`,`amount` FROM `additionalRcp` WHERE `section` = 'INV'
                       AND STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN STR_TO_DATE('$fdate', '%d/%m/%Y') AND STR_TO_DATE('$tdate', '%d/%m/%Y')";
    $queryReceivables = mysqli_query($conn,$sqlReceivables);
    $receivables=0;
    while($resultReceivables = mysqli_fetch_array($queryReceivables)) {
        
        $invoice = $resultReceivables['invoice'];
        $invoicedAmount = $resultReceivables['amount'];
        $invoicedAmount = ($invoicedAmount != NULL) ? $invoicedAmount : 0;
        
            $sqlReceipt = "SELECT sum(amount) AS receiptedAmount FROM `additionalRcp` WHERE `section` != 'INV' AND `invoice` = '$invoice'
                           AND STR_TO_DATE(`date`, '%d/%m/%Y') BETWEEN STR_TO_DATE('$fdate', '%d/%m/%Y') AND STR_TO_DATE('$tdate', '%d/%m/%Y')";
            $queryReceipt = mysqli_query($conn,$sqlReceipt);
            $resultReceipt = mysqli_fetch_array($queryReceipt);
            $receiptedAmount = $resultReceipt['receiptedAmount'];
            $receiptedAmount = ($receiptedAmount != NULL) ? $receiptedAmount : 0;
            
        $receivables = ($receivables+$invoicedAmount+$receiptedAmount);
    }
    echo $receivables;
    ?>
    </div>
    
<script>
window.addEventListener("load", function() {
    // Hide the preloader when the page is fully loaded
    const preloader = document.querySelector(".preloader");
    const content = document.querySelector(".content");

    preloader.style.display = "none";
    content.style.display = "block";
});
</script>
</body>

</html>