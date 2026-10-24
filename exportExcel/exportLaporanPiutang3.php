<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

	$year	= date('Y');
	$mtype	= $_POST['mtype'];
	$date 	= date("d M Y");

    // Query untuk mengambil data
    if($mtype=='Semua'){
		$sql = "select m.merchant_id, m.merchant_name, l.lapak_name, 
		l.lapak_size, l.lapak_total, r.rent_dp, r.leftover, r.rent_date
		from rent r,  merchant m, lapak l
		where r.merchant_id = m.merchant_id and
		l.lapak_id = r.lapak_id and 
		m.merchant_status = 'Aktif'  and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		order by m.merchant_id";
		//r.rent_sts != 'Lunas' and
		//QUery Jumlah Total Pedagang
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'");
	}else{
		$sql = "select m.merchant_id, m.merchant_name, l.lapak_name, 
		l.lapak_size, l.lapak_total, r.rent_dp, r.leftover, r.rent_date
		from rent r,  merchant m, lapak l
		where r.merchant_id = m.merchant_id and
		l.lapak_id = r.lapak_id and 
		m.merchant_type = '".$mtype."' and
		m.merchant_status = 'Aktif'  and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'
		order by m.merchant_id";
		
		//QUery Jumlah Total Pedagang
		$totalMerchant = executeScalar("select count(distinct(m.merchant_id)) from merchant m, rent r
		where m.merchant_id = r.merchant_id and m.merchant_status = 'Aktif' and
		m.merchant_type = '".$mtype."' and
		r.rent_sts != 'Batal' and
		r.rent_sts2 != 'Batal' and
		r.rent_sts2 != 'pindah'");
	}

    $query 	= mysql_query($sql);

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Data Piutang");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN DATA PIUTANG PER LAPAK");
    $sheet->setCellValue("A3", "JUMLAH PEDAGANG");
    $sheet->setCellValue("A4", "JENIS PEDAGANG");
    $sheet->setCellValue("B3", " : ");
    $sheet->setCellValue("B4", " : ");
    $sheet->setCellValue("C3", $totalMerchant . ' Orang');
    $sheet->setCellValue("C4",$mtype);

    // Membuat text bold
    $sheet->getStyle("A1:B4")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1:B4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A3:A4")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    // Merge cell
    $sheet->mergeCells("A1:I1");

    // Menulis header
    $sheet->setCellValue("A6", "NO")
          ->setCellValue("B6", "KODE")
          ->setCellValue("C6", "NAMA PEDAGANG")
          ->setCellValue("D6", "LAPAK")
          ->setCellValue("E6", "LUAS")
          ->setCellValue("F6", "TGL SEWA")
          ->setCellValue("G6", "TOTAL HARGA (RP)")
          ->setCellValue("H6", "UANG MUKA (RP)")
          ->setCellValue("I6", "PIUTANG (RP)");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A6:I6')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A6:I6")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A6:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 7;

    // Looping untuk mengambil dan menuliskan data
    while ($data = mysql_fetch_array($query)) {

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $data['merchant_id'])
              ->setCellValue("C" . $row, $data['merchant_name'])
              ->setCellValue("D" . $row, $data['lapak_name'])
              ->setCellValue("E" . $row, $data['lapak_size'] . ' M2')
              ->setCellValue("F" . $row, date("d M Y", strtotime($data['rent_date'])))
              ->setCellValue("G" . $row, $data['lapak_total'])
              ->setCellValue("H" . $row, $data['rent_dp'])
              ->setCellValue("I" . $row, $data['leftover']);
            
        // Membuat format menjadi number
        $sheet->getStyle("E" . $row . ":E" . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle("G" . $row . ":I" . $row)->getNumberFormat()->setFormatCode('#,##0');

        $no++;
        $row++;
    }

    // Menulis total pada baris terakhir
    if ($row > 7) {
        $sheet->mergeCells("A" . $row . ":F" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("G" . $row, "=SUM(G7:G" . ($row - 1) . ")")
              ->setCellValue("H" . $row, "=SUM(H7:H" . ($row - 1) . ")")
              ->setCellValue("I" . $row, "=SUM(I7:I" . ($row - 1) . ")");
    } else {
        $sheet->mergeCells("A" . $row . ":E" . $row); 
        $sheet->setCellValue("A" . $row, "TOTAL")
              ->setCellValue("F" . $row,  0)
              ->setCellValue("G" . $row,  0)
              ->setCellValue("H" . $row,  0)
              ->setCellValue("I" . $row,  0);
    }

    // Mengatur warna latar belakang kuning untuk baris total
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle("A" . $row . ":I" . $row)->getFill()->getStartColor()->setRGB('FFFF00'); // Warna Kuning

    // Membuat Text Bold
    $sheet->getStyle("A" . $row . ":I" . $row)->getFont()->setBold(true);

    // Meratakan teks "TOTAL" ke tengah
    $sheet->getStyle("A" . $row . ":I" . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Membuat format menjadi number
    $sheet->getStyle("F" . $row . ":I" . $row)->getNumberFormat()->setFormatCode('#,##0');

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A6:I" . $row)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Data Piutang Per Lapak' . ' (' .$mtype. ')_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>
