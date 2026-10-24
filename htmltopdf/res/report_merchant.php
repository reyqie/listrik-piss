<?php
include "../connection.php";
?>

<page backtop="10mm" backbottom="10mm" backleft="0mm" backright="0mm">

    <!-- HEADER -->
    <page_header>
        <table style="width:100%;font-size:10pt;">
            <tr>
                <td style="width:50%;"></td>
                <td style="width:50%;text-align:right;">
                    Dicetak : <?php echo date('d M Y'); ?>
                </td>
            </tr>
        </table>
    </page_header>

    <!-- FOOTER -->
    <page_footer>
        <table style="width:100%;font-size:10pt;">
            <tr>
                <td style="width:50%;"></td>
                <td style="width:50%;text-align:right;">
                    Halaman [[page_cu]] / [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>

    <!-- TITLE -->
    <div style="font-size: 18px; font-weight: bold; text-align: center; margin-top:15px;">
		LAPORAN DATA PENGGUNA LISTRIK <br>
		PASAR INDUK SURABAYA SIDOTOPO (PISS) 
	</div>

    <br><br>

    <!-- TABLE -->
    <table style="width:100%;border-collapse:collapse;font-size:8pt;">

        <thead>
            <tr>

                <th style="width:2%;border:1px solid black;text-align:center;">
                    NO
                </th>

                <th style="width:5%;border:1px solid black;text-align:center;">
                    KODE
                </th>

                <th style="width:17%;border:1px solid black;text-align:center;">
                    PENGGUNA
                </th>

                <th style="width:12%;border:1px solid black;text-align:center;">
                    LAPAK
                </th>

                <th style="width:7%;border:1px solid black;text-align:center;">
                    DAYA
                </th>

                <th style="width:10%;border:1px solid black;text-align:center;">
                    TARIF
                </th>

                <th style="width:9%;border:1px solid black;text-align:center;">
                    STS PEDAGANG
                </th>

                <th style="width:9%;border:1px solid black;text-align:center;">
                    STS LISTRIK
                </th>

                <th style="width:12%;border:1px solid black;text-align:center;">
                    PETUGAS
                </th>

                <th style="width:10%;border:1px solid black;text-align:center;">
                    MULAI LANGGANAN
                </th>

            </tr>
        </thead>

        <tbody>

<?php

$query=mysql_query("
select *
from electricity
order by electricity_id desc
");

$no=1;

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
?>

            <tr>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $no; ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $data['merchant_id']; ?>
                </td>

                <td style="border:1px solid black;padding:5px;">
                    <?php echo $name; ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $lapak?$lapak:'Tidak Ada'; ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $ampere; ?> Amp
                </td>

                <td style="border:1px solid black;padding:5px;text-align:right;">
                    <?php echo format_rupiah($price); ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $statusPedagang; ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo $data['electricity_sts']; ?>
                </td>

                <td style="border:1px solid black;padding:5px; text-align:center;">
                    <?php echo $petugas; ?>
                </td>

                <td style="border:1px solid black;padding:5px;text-align:center;">
                    <?php echo date('d M Y',strtotime($data['register_date'])); ?>
                    <br>
                    <span style="font-size:7pt;">
                        <?php echo timeAgo($data['register_date']); ?>
                    </span>
                </td>

            </tr>

<?php

$no++;

}

?>

        </tbody>

    </table>

</page>