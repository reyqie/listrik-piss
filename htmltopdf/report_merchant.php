<?php
	// get the HTML
	ob_start();
	include(dirname(__FILE__).'/res/report_merchant.php');
	$content = ob_get_clean();

	// convert to PDF
	require_once(dirname(__FILE__).'/html2pdf.class.php');
	try{
		$html2pdf = new HTML2PDF('P', 'A4', 'fr', array(20, 10, 20, 10));
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->writeHTML($content);
		$html2pdf->Output('Laporan Data Pedagang PISS.pdf', 'I');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
?>