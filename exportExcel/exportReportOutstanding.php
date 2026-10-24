<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$total		= 0;

    // Query untuk mengambil data
    $query = mysql_query("
        SELECT DISTINCT 
            p.pay_id, 
            p.merchant_id, 
            p.pay_total, 
            p.pay_sts,
            p.id_lapak_dipasang, 
            p.periode_id,
            e.electricity_sts
        FROM e_pay p
        JOIN electricity e ON p.merchant_id = e.merchant_id
        WHERE p.pay_sts = 'Belum Lunas'
        ORDER BY p.periode_id, p.merchant_id
    ");


    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Pembatalan Tagihan");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN PEMBATALAN TAGIHAN LISTRIK");
    // $sheet->setCellValue("A3", "TANGGAL");
    // $sheet->setCellValue("B3", " : ");
    // $sheet->setCellValue("C3", date('d M Y', strtotime($date1)) . ' s/d ' . date('d M Y', strtotime($date2)));

    // Membuat text bold
    $sheet->getStyle("A1")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    // $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:J1");

    // Menulis header
    $sheet->setCellValue("A3", "NO")
          ->setCellValue("B3", "KODE TAGIHAN")
          ->setCellValue("C3", "PENGGUNA LISTRIK")
          ->setCellValue("D3", "STATUS PEDAGANG")
          ->setCellValue("E3", "STATUS LISTRIK")
          ->setCellValue("F3", "LAPAK PASANG")
          ->setCellValue("G3", "DAYA")
          ->setCellValue("H3", "PERIODE")
          ->setCellValue("I3", "TARIF")
          ->setCellValue("J3", "TAGIHAN");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A3:I3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A3:I3')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A3:J3")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 4;

    // Looping untuk mengambil dan menuliskan data
    while ($r = mysql_fetch_array($query)) {
        $tlid 		= sprintf("%07d", $r['pay_id']);
		$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Pindah' && rent_sts2 != 'Batal') limit 1");
		$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
		$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
		$tarif		= executeScalar("select e_cost_id from electricity where merchant_id = '".$r['merchant_id']."' and id_lapak_dipasang = '".$r['id_lapak_dipasang']."'");
		$price		= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$tarif."'");
		$ampere		= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
		$periode	= executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
        $merchantSts= executeScalar("select merchant_status from merchant where merchant_id = '".$r['merchant_id']."'");

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $tlid)
              ->setCellValue("C" . $row, $name)
              ->setCellValue("D" . $row, $merchantSts)
              ->setCellValue("E" . $row, $r['electricity_sts'])
              ->setCellValue("F" . $row, $lapak)
              ->setCellValue("G" . $row, $ampere . " Ampere")
              ->setCellValue("H" . $row, $periode)
              ->setCellValue("I" . $row, $price)
              ->setCellValue("J" . $row, $r['pay_total']);
            
        // Membuat format menjadi number
        $sheet->getStyle("I" . $row . ":I" . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("J" . $row . ":J" . $row)->getNumberFormat()->setFormatCode('#,##0');

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
    if ($row > 4) {
        $sheet->mergeCells("A" . $row . ":I" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("J" . $row, "=SUM(J4:J" . ($row - 1) . ")");
    } else {
        $sheet->mergeCells("A" . $row . ":I" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("J" . $row,  0);
    }

    // Mengatur warna latar belakang kuning untuk baris total
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->getStartColor()->setRGB('FFFF00'); // Warna Kuning

    // Membuat Text Bold
    // $sheet->getStyle("A" . $row . ":J" . $row)->getFont()->setBold(true);

    // Meratakan teks "TOTAL" ke tengah
    // $sheet->getStyle("A" . $row . ":J" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Membuat format menjadi number
    $sheet->getStyle("J" . $row . ":J" . $row)->getNumberFormat()->setFormatCode('#,##0');

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A3:J" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Pembatalan Tagihan Listrik_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>
