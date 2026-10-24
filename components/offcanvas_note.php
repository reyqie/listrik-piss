<?php
    // Mengambil data versi terbaru dari database

    $version_query = mysql_query("SELECT version, date FROM update_listrik ORDER BY id DESC LIMIT 1");
    $version_data = mysql_fetch_array($version_query);
    $latestDate = $version_data['date'];          // format YYYY-MM-DD
    $today      = date("Y-m-d");
    // Hitung selisih hari (2hari)
    $diff = (strtotime($today) - strtotime($latestDate)) / (60 * 60 * 24);
?>    

<style>
    /* Style untuk tombol */
    .btn-canvas {
        /* padding: 10px 20px; */
        /* margin-top: 40px; */
        /* margin-bottom: 100px; */
        /* margin-left: 40px; */
        color: #fff;
        border: none;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        position: relative;
        background-color: #EC9841;
    }

    .btn-canvas:hover {
        background-color: #f0ad4e;
    }

    .notification {
        display: block;
        position: absolute;
        top: -5px;
        right: -10px;
        background-color: red;
        color: white;
        border-radius: 50%;
        padding: 2px 5px;
        font-size: 8px;
    }

    .notification.hidden {
        display: none;
    }

    /* Style untuk offcanvas */
    .offcanvas {
        position: fixed;
        top: 50%; 
        left: 50%; 
        width: 50%;
        height: 60%;
        background-color: #f8f9fa;
        transition: transform 0.3s ease, opacity 0.3s ease;
        z-index: 1050;
        padding: 20px;
        border-radius: 5px;
        border: 2px solid #428bca;
        transform: translate(-50%, -50%) scale(0); 
        opacity: 0; 
        overflow-y: auto;
    }

    /* Header offcanvas */
    .offcanvas-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #428bca;
        color: white;
        padding: 10px 20px 10px 20px;
        border-radius: 10px;
    }

    /* Tombol tutup */
    .close-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: white;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #f8f9fa;
    }

    /* Isi offcanvas */
    .offcanvas-body {
        margin-top: 20px;
    }

    /* Tampilkan offcanvas */
    .offcanvas.show {
        transform: translate(-50%, -50%) scale(1); 
        opacity: 1; 
    }

    /* Tampilan gambar ketika tidak ada update sistem */
    .box-update {
        display: flex; 
        flex-direction: column;
        align-items: center; 
        justify-content: center; 
        height: 100%; 
        text-align: center;
    }

</style>

<!-- Tombol untuk memunculkan offcanvas -->
<button class="btn btn-canvas btn-primary" onclick="toggleOffcanvas()">
    <i class="fa fa-bell"></i>
    <?php 
        if (!empty($version_data['version']) && $diff <= 2) { ?>
            <div class="notification">
                New
            </div>
        <?php }
    ?>
</button>

<!-- Offcanvas -->
<div id="offcanvasTop" class="offcanvas">
    <div class="offcanvas-header">
        <h5 id="offcanvas-title"></h5>
        <button class="close-btn" onclick="toggleOffcanvas()"><i class="fa fa-close"></i></button>
    </div>
    <div class="offcanvas-body">
        <?php 
        if (!empty($version_data['version']) && $diff <= 2) { ?>
            <!-- Jika ada pembaruan sistem -->
            <table>
                <?php
                    // Menampilkan daftar pembaruan sistem terbaru
                    $updates_query = mysql_query("SELECT description FROM update_desc_listrik WHERE update_listrik_id = (SELECT id FROM update_listrik ORDER BY id DESC LIMIT 1)");
                    while ($update = mysql_fetch_array($updates_query)) {
                        echo "
                            <tr>
                                <td style='font-size:28px; padding-right: 20px;'> • </td>
                                <td>" . $update['description'] . "</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        <?php } else { ?>
            <!-- Jika tidak ada pembaruan sistem -->
            <div class="box-update">
                <img src="img/update.png" alt="Update Illustration" width="210px">
                <h3 class="text-primary text-uppercase"><b>Tidak ada pembaruan sistem</b></h3>
            </div>
        <?php } ?>
    </div>
    <div class="offcanvas-footer" style="margin-top: 30px; text-align: center;">
        <p class="text-primary text-uppercase text-center">
            <b>
                Version
                <?php
                    echo $version_data['version'];
                ?>
            </b>
        </p>
    </div>
</div>

<script>
    function getFormattedDate() {
        const now = new Date();
        const option = {day: 'numeric', month: 'long', year: 'numeric'};
        return now.toLocaleDateString('id-ID', option);
    }

    document.getElementById('offcanvas-title').innerHTML = `<b><i class="fa fa-info-circle" style="font-size:20px"></i>&nbsp;&nbsp;Pembaruan Sistem (${getFormattedDate()})</b>`;


    function toggleOffcanvas() {
        const offcanvas = document.getElementById('offcanvasTop');
        const notification = document.querySelector('.notification');
        
        if (offcanvas.classList.contains('show')) {
            offcanvas.classList.remove('show');
        } else {
            offcanvas.classList.add('show'); 
        }

        if (notification) {
            notification.style.display = 'none';
            localStorage.setItem('notificationHidden', 'true');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const notificationHidden = localStorage.getItem('notificationHidden');
        const notification = document.querySelector('.notification');
        
        if (notificationHidden === 'true' && notification) {
            notification.classList.add('hidden');
        }
    });
</script>
