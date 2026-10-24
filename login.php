<?php
    include "connection.php";
    $version_query = mysql_query("SELECT version, date FROM update_listrik ORDER BY id DESC LIMIT 1");
    $version_data = mysql_fetch_array($version_query);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | PISS</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="img/icon.png" />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/bootstrap/css/bootstrap.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/animate/animate.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/css-hamburgers/hamburgers.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/animsition/css/animsition.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/select2/select2.min.css"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="vendor/daterangepicker/daterangepicker.css"
        />
        <link rel="stylesheet" type="text/css" href="css/util.css" />
        <link rel="stylesheet" type="text/css" href="css/login.css" />
    </head>
    <body style="background-color: #666666">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <form
                        method="post"
                        action="checklogin.php"
                        class="login100-form validate-form"
                    >
                        <span class="login100-form-title pb-3">
                            Login Listrik
                            <span style="color: #428bca; font-weight: 700"
                                >PISS👋</span
                            >
                        </span>
                        <p class="text-center" style="margin-top: -10px">
                            Version <?php echo $version_data['version']; ?>
                        </p>

                        <div class="illustration text-center mb-4 mt-3">
                            <img
                                src="img/login.png"
                                alt="Illustration"
                                width="330"
                            />
                        </div>

                        <div
                            class="wrap-input100 validate-input"
                            data-validate="Username is required"
                        >
                            <i
                                class="fa fa-user"
                                aria-hidden="true"
                                style="
                                    position: absolute;
                                    top: 12px;
                                    left: 12px;
                                    color: #428bca;
                                "
                            ></i>
                            <input
                                id="user"
                                class="form-control input100"
                                type="text"
                                name="user"
                            />
                            <span class="focus-input100"></span>
                            <span class="label-input100"
                                >Masukkan Username</span
                            >
                        </div>

                        <div
                            class="wrap-input100 validate-input"
                            data-validate="Password is required"
                        >
                            <i
                                class="fa fa-lock"
                                aria-hidden="true"
                                style="
                                    position: absolute;
                                    top: 12px;
                                    left: 12px;
                                    color: #428bca;
                                "
                            ></i>
                            <input
                                id="password"
                                class="form-control input100"
                                type="password"
                                name="pass"
                            />
                            <span class="focus-input100"></span>
                            <span class="label-input100"
                                >Masukkan Password</span
                            >
                            <i
                                class="fa fa-eye-slash"
                                aria-hidden="true"
                                id="togglePassword"
                                style="
                                    position: absolute;
                                    top: 12px;
                                    right: 12px;
                                    color: #428bca;
                                    cursor: pointer;
                                "
                            ></i>
                        </div>

                        <div class="flex-sb-m w-full p-t-3 p-b-32">
                            <div class="contact100-form-checkbox">
                                <input
                                    class="input-checkbox100"
                                    id="ckb1"
                                    type="checkbox"
                                    name="remember"
                                />
                                <label class="label-checkbox100" for="ckb1">
                                    Ingat saya
                                </label>
                            </div>
                            <div>
                                <a
                                    href="#"
                                    class="txt1"
                                    data-toggle="modal"
                                    data-target="#modalForgetPassword"
                                    style="
                                        color: #428bca;
                                        text-decoration: none;
                                    "
                                >
                                    Lupa Password?
                                </a>
                            </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                Masuk
                                <i
                                    class="fa fa-plane"
                                    aria-hidden="true"
                                    style="color: #ffffff; margin-left: 10px"
                                ></i>
                            </button>
                        </div>
                    </form>

                    <div class="login100-more">
                        <div class="text-overlay">
                            <h1>Selamat Datang,</h1>
                            <br />
                            <h1 id="subtitle-text"></h1>
                        </div>
                        <video
                            autoplay
                            loop
                            muted
                            playsinline
                            class="background-video"
                        >
                            <source src="img/login.mp4" type="video/mp4" />
                        </video>
                        <div class="overlay"></div>

                        <div class="toast">
                            <div class="toast-header">
                                <img src="img/logo.png" alt="Logo" />
                                <strong class="me-auto">Developer PISS</strong>
                                <small>Sekarang</small>
                                <button
                                    type="button"
                                    class="btn-close"
                                    onclick="this.parentElement.parentElement.style.display='none';"
                                    aria-label="Close"
                                >
                                    &times;
                                </button>
                            </div>
                            <div class="toast-body">
                                Selamat bekerja, jangan lupa jaga kesehatan
                                <i class="fa fa-heart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Forget Password -->
        <div
            id="modalForgetPassword"
            class="modal fade"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Meload modal "forget_password.php" file -->
                </div>
            </div>
        </div>

        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/animsition/js/animsition.min.js"></script>
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/daterangepicker/moment.min.js"></script>
        <script src="vendor/daterangepicker/daterangepicker.js"></script>
        <script src="vendor/countdowntime/countdowntime.js"></script>
        <script src="js/login.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.getElementById("user").focus();
            });

            document
                .getElementById("togglePassword")
                .addEventListener("click", function () {
                    const passwordField = document.getElementById("password");
                    const icon = this;

                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        icon.classList.add("fa-eye-slash");
                        icon.classList.remove("fa-eye");
                    } else {
                        passwordField.type = "password";
                        icon.classList.add("fa-eye");
                        icon.classList.remove("fa-eye-slash");
                    }
                });
        </script>
        <script>
            $(document).ready(function () {
                $("#modalForgetPassword").on("show.bs.modal", function () {
                    $(this).find(".modal-content").load("forget_password.php");
                });
            });
        </script>
        <script>
            // Fungsi untuk set cookie
            function setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    const date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

            // Fungsi untuk ambil cookie
            function getCookie(name) {
                const nameEQ = name + "=";
                const ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            // Fungsi untuk hapus cookie
            function eraseCookie(name) {
                document.cookie = name + "=; Max-Age=-99999999;";
            }

            // Saat DOM siap
            document.addEventListener("DOMContentLoaded", function () {
                const usernameInput = document.getElementById("user");
                const passwordInput = document.getElementById("password");
                const rememberCheckbox = document.getElementById("ckb1");

                // Jika ada cookie, isi otomatis
                if (getCookie("user") && getCookie("password")) {
                    usernameInput.value = getCookie("user");
                    passwordInput.value = getCookie("password");
                    rememberCheckbox.checked = true;
                }

                // Saat form disubmit
                const form = document.querySelector("form");
                form.addEventListener("submit", function () {
                    if (rememberCheckbox.checked) {
                        setCookie("user", usernameInput.value, 7); // simpan 7 hari
                        setCookie("password", passwordInput.value, 7);
                    } else {
                        eraseCookie("user");
                        eraseCookie("password");
                    }
                });
            });
        </script>
    </body>
</html>
