<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Page</title>
    <style>
        #loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #loading-bar {
            width: 100%;
            max-width: 400px;
            height: 4px;
            background-color: #0074D9;
        }

        #loading-text {
            font-size: 24px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="loading-container">
        <div id="loading-bar"></div>
        <div id="loading-text">0%</div>
    </div>

    <!-- Your page content goes here -->
    
    <?php
    include "../../config.php";
    // finding receivables
    
    $fdate = '01/09/2023';
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

    <script>
        // Simulate loading assets (you should replace this with your actual asset loading logic)
        const simulateAssetLoading = () => {
            const assets = ["image1.jpg", "image2.jpg", "stylesheet.css", "script.js"];
            let loadedCount = 0;

            const updateLoading = () => {
                loadedCount++;
                const loadProgress = Math.min((loadedCount / assets.length) * 100, 100);
                document.getElementById("loading-bar").style.width = loadProgress + "%";
                document.getElementById("loading-text").textContent = Math.round(loadProgress) + "%";

                if (loadedCount === assets.length) {
                    setTimeout(() => {
                        document.getElementById("loading-container").style.display = "none";
                    }, 500);
                }
            };

            assets.forEach((asset) => {
                // Simulate loading each asset (replace this with actual asset loading code)
                setTimeout(() => {
                    updateLoading();
                }, Math.random() * 2000);
            });
        };

        simulateAssetLoading();
    </script>
</body>
</html>