
<?php
    include "components/role_session.php";
?>

<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: black; overflow: hidden;">
    <div id="title" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
        <h1 id="typedText"  style="color: white; font-size: 50px; font-family: Arial, sans-serif; text-transform: capitalize;"></h1>
    </div>

    <!-- Canvas untuk warp speed -->
    <canvas id="warpCanvas" style="width: 100%; height: 100%;"></canvas>

    <!-- Lingkaran efek fade-out -->
    <div id="fadeCircle" 
        style="position: fixed; 
               top: 50%; 
               left: 50%; 
               width: 0; 
               height: 0; 
               background: white; 
               border-radius: 50%; 
               transform: translate(-50%, -50%); 
               z-index: 10; 
               transition: width 2s, height 2s;">
    </div>
</div>

<script>
    // Warp Speed Animation
    const canvas = document.getElementById('warpCanvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const stars = [];
    for (let i = 0; i < 500; i++) {
        stars.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            z: Math.random() * canvas.width,
        });
    }

    function animate() {
        ctx.fillStyle = 'black';
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        for (let star of stars) {
            star.z -= 5;
            if (star.z <= 0) {
                star.z = canvas.width;
                star.x = Math.random() * canvas.width;
                star.y = Math.random() * canvas.height;
            }

            const k = 400 / star.z;
            const x = (star.x - canvas.width / 2) * k + canvas.width / 2;
            const y = (star.y - canvas.height / 2) * k + canvas.height / 2;
            const size = (1 - star.z / canvas.width) * 2;

            ctx.beginPath();
            ctx.arc(x, y, size, 0, Math.PI * 2);
            ctx.fillStyle = '#FFF';
            ctx.fill();
        }
        requestAnimationFrame(animate);
    }
    animate();


    // Typing effect for the title text
    const textElement = document.getElementById("typedText");
    const textToType = "Selamat Datang, <?php echo $name; ?>";
    let currentIndex = 0;

    // Mulai teks dalam keadaan kosong dan tampilkan satu per satu
    function typeText() {
        if (currentIndex < textToType.length) {
            textElement.innerHTML += textToType[currentIndex];
            currentIndex++;
            setTimeout(typeText, 80); // Kecepatan ketikan dapat disesuaikan di sini
        }
    }

    // Menunggu 1 detik sebelum memulai efek ketikan
    setTimeout(() => {
        typeText();
    }, 400); // Durasi penundaan sebelum ketikan dimulai

    // Trigger fade-out circle dan redirect
    setTimeout(() => {
        const fadeCircle = document.getElementById('fadeCircle');
        fadeCircle.style.width = "3000px"; // Lingkaran membesar menutupi layar
        fadeCircle.style.height = "3000px";

        // Redirect ke halaman baru setelah animasi selesai
        setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 2000); // Waktu sinkron dengan durasi animasi lingkaran
    }, 3000); // Waktu tunggu sebelum animasi fade-out mulai
</script>
