<?php
	// get the HTML
	ob_start();
	
	include(dirname(__FILE__).'/res/merchant_bill.php');
	$content = ob_get_clean();

	// convert to PDF
	require_once(dirname(__FILE__).'/html2pdf.class.php');
	try{
		//$custom_layout = array(120, 120);
		$html2pdf = new HTML2PDF('P', 'A6', 'fr', array(5, 10, 5, 10));
		//$html2pdf = new HTML2PDF('P', $custom_layout, 'fr');
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content);
		$html2pdf->Output('Tagihan Listrik PISS.pdf', 'I');
	}
	catch(HTML2PDF_exception $e){
		echo $e;
		exit;
	}
?>