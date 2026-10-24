<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$date1		= $_POST['date1'];
	$date2		= $_POST['date2'];
	$total		= 0;

    // Query untuk mengambil data
    $query 	= mysql_query("select p.pay_id, p.merchant_id, p.pay_total, p.cancel_date, p.pay_sts, 
					c.e_cost_ampere, c.e_cost_price, p.periode_id, e.e_cost_id, pr.periode_name
					from e_pay p, e_periode pr, electricity e, e_cost c
					where p.periode_id = pr.periode_id and
					p.merchant_id = e.merchant_id and
					e.e_cost_id = c.e_cost_id and
					p.pay_sts = 'Batal' and
					(p.cancel_date between '".$date1."' and '".$date2."')
					order by p.pay_date, pr.periode_name, p.merchant_id");

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Pembatalan Tagihan");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN TAGIHAN LISTRIK OFF");
    $sheet->setCellValue("A3", "TANGGAL");
    $sheet->setCellValue("B3", " : ");
    $sheet->setCellValue("C3", date('d M Y', strtotime($date1)) . ' s/d ' . date('d M Y', strtotime($date2)));

    // Membuat text bold
    $sheet->getStyle("A1:B3")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1:B3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A3:A3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:H1");

    // Menulis header
    $sheet->setCellValue("A5", "NO")
          ->setCellValue("B5", "NO TAGIHAN")
          ->setCellValue("C5", "PENGGUNA LISTRIK")
          ->setCellValue("D5", "LAPAK")
          ->setCellValue("E5", "DAYA")
          ->setCellValue("F5", "PERIODE")
          ->setCellValue("G5", "TGL OFF")
          ->setCellValue("H5", "TARIF");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A5:H5")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A5:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 6;

    // Looping untuk mengambil dan menuliskan data
    while ($r = mysql_fetch_array($query)) {
        $tlid 		= sprintf("%07d", $r['pay_id']);
		$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Pindah' && rent_sts2 != 'Batal') limit 1");
		$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
		$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, "TL".$tlid)
              ->setCellValue("C" . $row, $name)
              ->setCellValue("D" . $row, $lapak)
              ->setCellValue("E" . $row, $r['e_cost_ampere'])
              ->setCellValue("F" . $row, $r['periode_name'])
              ->setCellValue("G" . $row, date("d M Y", strtotime($r['cancel_date'])))
              ->setCellValue("H" . $row, $r['e_cost_price']);
            
        // Membuat format menjadi number
        $sheet->getStyle("H" . $row . ":H" . $row)->getNumberFormat()->setFormatCode('#,##0');

        // Perhitungan total
        // if ($data['weighing_sts'] != 'Batal' && $data['weighing_sts'] != 'Dipecah' && $data['weighing_sts'] != 'Digabung') {
        //     $weight_in += $data['weight_in'];
        //     $weight_out += $data['weight_out'];
        //     $noncommodity += $data['noncommodity'];
        //     $rafaksi += $data['rafaksi'];
        //     $netto += $data['netto'];
        // }

        $no++;
        $row++;
    }

    // Menulis total pada baris terakhir
    if ($row > 6) {
        $sheet->mergeCells("A" . $row . ":G" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("H" . $row, "=SUM(H6:H" . ($row - 1) . ")");
    } else {
        $sheet->mergeCells("A" . $row . ":G" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("H" . $row,  0);
    }

    // Mengatur warna latar belakang kuning untuk baris total
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->getStartColor()->setRGB('FFFF00'); // Warna Kuning

    // Membuat Text Bold
    // $sheet->getStyle("A" . $row . ":J" . $row)->getFont()->setBold(true);

    // Meratakan teks "TOTAL" ke tengah
    // $sheet->getStyle("A" . $row . ":J" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Membuat format menjadi number
    $sheet->getStyle("H" . $row . ":H" . $row)->getNumberFormat()->setFormatCode('#,##0');

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A5:H" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Pembatalan Tagihan Listrik_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>
