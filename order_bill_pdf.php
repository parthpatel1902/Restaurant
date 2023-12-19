<?php 

ob_start();
        
include('dbconf.php');
        
// Include the main TCPDF library (search for installation path).
require_once('TCPDF-main/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);



// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();



$user_id = $_GET['user_id'];
$order_id = $_GET['order_id'];
$query = "SELECT fname,lname,phone_number,email from customer where id=$user_id";
$res = $con->query($query)->fetch_assoc();
$name = $res['fname'];
$lname = $res['lname'];
$mno = $res['phone_number'];
$email = $res['email'];

$order_items_str = "";
$order_items_query = "SELECT CT.*,item_name FROM CART AS CT
                        LEFT JOIN MENU_ITEM AS MI ON MI.ID = CT.MENU_ITEM_ID
                        WHERE CT.ORDER_ID = $order_id ;";
$order_items = $con->query($order_items_query);
$xtotal = 0;
foreach ($order_items as $order_item) {

    $itemName = $order_item['item_name'];
    $orderQty = $order_item['qty'];
    $orderPrice = $order_item['price'];
    $orderSubtotal = $order_item['subtotal'];
    $xtotal = $xtotal + $orderSubtotal;
    $order_items_str = $order_items_str."<tr>
        <td>$itemName</td>
        <td>$orderQty</td>
        <td>$orderPrice</td>
        <td>$orderSubtotal</td>
    </tr>";

}

$html = '
<h1 style="text-align:center;"><u>Bill Details</u></h1>
<label style="font-weight:bold;">Customer Name : - '.$name .' '.$lname .'</label><br><br>
<label style="font-weight:bold;">Customer Moblie Number : - '.$mno.'</label><br><br>
<label style="font-weight:bold;">Customer Email : - '.$email.'</label><br><br>
<table cellspacing="0" cellpadding="1" border="1" style="border-color:gray;">
    
    <tr style="background-color:green;color:white;">
        <td>Item Name</td>
        <td>Qty</td>
        <td>Price</td>
		<td>Sub Total</td>
    </tr>'.$order_items_str.'
</table><br><b><center><p>Total Amount : - '.$xtotal.'</center></b></p>';

// Print text using writeHTMLCell()
// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTML($html, true, false, true, false, '');
ob_end_flush();
$pdf->Output("INVOICE-$order_id.pdf", 'I');
?>