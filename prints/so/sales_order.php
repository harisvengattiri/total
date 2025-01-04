<?php 
$dno=$_GET["dno"];
$open=$_GET["open"];
$html = file_get_contents('http://mancon.gulfit.xyz/prints/sales_order_pdf?dno='.$dno.'&open='.$open);
include("../../includes/mpdf/mpdf.php");
$mpdf=new mPDF('utf-8', 'A4', 0, '', 10, 10, 30, 0, 0, 0);
$mpdf->setAutoTopMargin = 'stretch';
$mpdf->showWatermarkImage = true;
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);
$mpdf->Output('Delivery Note #'.$dno.'.pdf', 'I');
exit;
?>