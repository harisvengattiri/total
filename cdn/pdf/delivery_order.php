<?php
require_once "../../config.php";

$order = $_GET["id"];

$html = file_get_contents(BASEURL.'/prints/order_pdf?id='.$order);
require_once('vendor/autoload.php');

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4','margin_left' => 10,'margin_right' => 10,'margin_top' => 30,'margin_bottom' => 10,'margin_header' => 0,'margin_footer' => 0,]);

$mpdf->setAutoTopMargin = 'stretch';
$mpdf->showWatermarkImage = true;
$mpdf->setAutoBottomMargin = 'stretch';
$mpdf->SetDisplayMode('fullpage');
$stylesheet = file_get_contents(BASEURL.'/prints/pdf_table.css');
$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML($html);
$mpdf->Output('Delivery Order #'.$order.'.pdf', 'I');
exit;
?>
