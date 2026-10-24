<style>
    .time-text {
        font-weight: bold;
        font-size: 14px;
    }

    .btn.btn-clock {
        background-color: #EC9841;
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    i.icon-clock {
        color: white;
    }

    .time-text {
        color: white;
    }

    /* Efek berkedip merah */
    .blink {
        animation: blink-bg 1s infinite;
    }

    @keyframes blink-bg {
        0% { background-color: #EC9841; }
        50% { background-color: red; }
        100% { background-color: #EC9841; }
    }
</style>

<!-- Tombol dengan jam berjalan -->
<div class="btn btn-clock" id="clock-btn">
    <i class="fa fa-clock-o icon-clock"></i>
    <span id="time-now" class="time-text">00:00 WIB</span>
</div>

<script>
    // Jadwal waktu sholat Surabaya (WIB)
    const prayerTimes = [
        { name: "Subuh",   hour: 3,  minute: 46 },
        { name: "Dzuhur",  hour: 11, minute: 17 },
        { name: "Ashar",   hour: 14, minute: 27 },
        { name: "Maghrib", hour: 17, minute: 26 },
        { name: "Isya",    hour: 18, minute: 37 },
    ];

    let isPraying = false; // status apakah sedang dalam waktu sholat

    function updateClock() {
        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')} WIB`;
        const timeDisplay = document.getElementById('time-now');
        const clockBtn = document.getElementById('clock-btn');

        if (!isPraying) {
            timeDisplay.textContent = formattedTime;
        }

        // Cek apakah waktu sholat sedang tiba
        prayerTimes.forEach(prayer => {
            if (hours === prayer.hour && minutes === prayer.minute && seconds < 120 && !isPraying) {
                isPraying = true;
                timeDisplay.textContent = `Sholat ${prayer.name}`;
                clockBtn.classList.add('blink');

                // Kembalikan ke normal setelah 1 menit
                setTimeout(() => {
                    clockBtn.classList.remove('blink');
                    isPraying = false;
                }, 60000);
            }
        });
    }

    // Jalankan setiap detik
    setInterval(updateClock, 1000);
    updateClock();
</script>
