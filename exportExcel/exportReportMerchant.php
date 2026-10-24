<?php
    include "../connection.php";
    require_once '../libs/PHPExcel/Classes/PHPExcel.php'; 
    // Load library PHPExcel

    // Query untuk mengambil data
    $query=mysql_query("
    select *
    from electricity
    order by electricity_id desc
    ");

    // Buat objek PHPExcel
    $excel = new PHPExcel();
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle("Laporan Data Pengguna Listrik");

    // Menulis Informasi di Atas Tabel
    $sheet->setCellValue("A1", "LAPORAN DATA PENGGUNA LISTRIK");

    // Membuat text bold
    $sheet->getStyle("A1")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah
    $sheet->getStyle("A1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    // Merge cell
    $sheet->mergeCells("A1:J1");

    // Menulis header
    $sheet->setCellValue("A4", "NO")
          ->setCellValue("B4", "KODE")
          ->setCellValue("C4", "PENGGUNA")
          ->setCellValue("D4", "LAPAK")
          ->setCellValue("E4", "DAYA")
          ->setCellValue("F4", "TARIF")
          ->setCellValue("G4", "STS PEDAGANG")
          ->setCellValue("H4", "STS LISTRIK")
          ->setCellValue("I4", "PETUGAS")
          ->setCellValue("J4", "MULAI LANGGANAN");

    // Mengatur warna latar belakang hijau untuk header
    // $sheet->getStyle('A5:I5')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    // $sheet->getStyle('A5:I5')->getFill()->getStartColor()->setRGB('7FBF7F'); // Warna Hijau

    // Membuat Text Bold
    $sheet->getStyle("A4:J4")->getFont()->setBold(true);

    // Meratakan semua teks ke tengah, kecuali kolom E (Pedagang)
    $sheet->getStyle('A4:J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $no			= 1;
    $row        = 5;

    // Looping untuk mengambil dan menuliskan data
    function timeAgo($date)
    {
        $now=new DateTime();
        $reg=new DateTime($date);
        $diff=$now->diff($reg);

        if($diff->y>=1)
            return $diff->y." tahun lalu";
        elseif($diff->m>=1)
            return $diff->m." bulan lalu";
        else
            return $diff->d." hari lalu";
    }

    while($data=mysql_fetch_array($query))
    {

        $price=executeScalar("
        select e_cost_price
        from e_cost
        where e_cost_id='".$data['e_cost_id']."'
        ");

        $ampere=executeScalar("
        select e_cost_ampere
        from e_cost
        where e_cost_id='".$data['e_cost_id']."'
        ");

        $name=executeScalar("
        select merchant_name
        from merchant
        where merchant_id='".$data['merchant_id']."'
        ");

        $petugas=executeScalar("
        select checker_name
        from checker
        where checker_id='".$data['id_petugas']."'
        ");

        $lapak=executeScalar("
        select lapak_name
        from lapak
        where lapak_id='".$data['id_lapak_dipasang']."'
        ");

        $statusPedagang=executeScalar("
        select merchant_status
        from merchant
        where merchant_id='".$data['merchant_id']."'
        ");

        // Meratakan semua teks ke tengah, kecuali kolom G (Pedagang)
        $sheet->getStyle('A:J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        // Set alignment khusus untuk kolom G (Pedagang) ke kiri
        $sheet->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        // Menulis data per baris
        $sheet->setCellValue("A" . $row, $no)
              ->setCellValue("B" . $row, $data['merchant_id'])
              ->setCellValue("C" . $row, $name)
              ->setCellValue("D" . $row, $lapak?$lapak:'Tidak Ada')
              ->setCellValue("E" . $row, $ampere)
              ->setCellValue("F" . $row, $price)
              ->setCellValue("G" . $row, $statusPedagang)
              ->setCellValue("H" . $row, $data['electricity_sts'])
              ->setCellValue("I" . $row, $petugas)
              ->setCellValue("J" . $row, date('d M Y', strtotime($data['register_date'])));

        $no++;
        $row++;
    }

    // Menambahkan border pada seluruh tabel
    $sheet->getStyle("A4:J" . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

    // Set header untuk download file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Laporan Data Penguuna Listrik_' . date('d M Y') . '.xls"');
    header('Cache-Control: max-age=0');

    // Menyimpan dan mendownload file Excel
    $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $objWriter->save('php://output');
    exit;
?>
