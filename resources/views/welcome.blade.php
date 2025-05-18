<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>SIORMAWA</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('landingpage/assets/img/fix.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('landingpage/assets/img/fix.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('landingpage/assets/img/fix.png') }}">
    <link rel="shortcut icon" sizes="" type="image/x-icon" href="{{ asset('landingpage/assets/img/fix.png') }}">
    <link rel="manifest" href="{{ asset('landingpage/assets/img/favicons/manifest.json') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    
    <meta name="msapplication-TileImage" content="{{ asset('landingpage/assets/img/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('landingpage/assets/css/theme.css') }}" rel="stylesheet" />

  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <nav class="navbar navbar-expand-sm navbar-light fixed-top" data-navbar-on-scroll="data-navbar-on-scroll">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img class="img-fluid" src="{{ asset('landingpage/assets/img/logopjg.png') }}" alt="" width="300" height="40"/>
                </a>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto ms-lg-4 ms-xl-7 border-bottom border-lg-bottom-0 pt-2 pt-lg-0">
                        <!-- Navigation items can be added here -->
                    </ul>
                    <form class="d-flex py-3 py-lg-0">
                        <a class="btn btn-primary btn-lg rounded-pill shadow fw-bold" href="/login" role="button">LOGIN
                            <svg class="bi bi-arrow-right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#9C69E2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </a>
                    </form>
                </div>
            </div>
        </nav>

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-5 col-lg-7 order-md-1 pt-8">
                        <img class="img-fluid" src="{{ asset('landingpage/assets/img/illustrations/hero-header.png') }}" alt="" />
                    </div>
                    <div class="col-md-7 col-lg-5 text-center text-md-start pt-5 pt-md-9">
                        <h1 class="mb-4 display-2 fw-bold">SIORMAWA<br class="d-block d-lg-none d-xl-block" />Politeknik Harapan Bersama</h1>
                        <p class="mt-3 mb-4">Sistem Informasi Ormawa merupakan platform digital yang dirancang untuk mengelola, mendokumentasikan, dan mempublikasikan kegiatan organisasi mahasiswa secara terstruktur, efisien, dan transparan.</p>
                    </div>
                </div>
            </div>
            <!-- end of .container-->
        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3 bg-soft-danger rounded-3">
                            <div class="row g-0 align-items-center">
                                <div class="col-md-5 col-lg-6 text-md-center">
                                    <img class="img-fluid" src="{{ asset('landingpage/assets/img/illustrations/about.png') }}" alt="" />
                                </div>
                                <div class="col-md-7 col-lg-6 px-md-2 px-xl-6 text-center text-md-start">
                                    <div class="card-body px-4 py-5 p-lg-3 p-md-4">
                                        <h1 class="mb-4 fw-bold">Platform Terpadu untuk Ormawa Poltek Harber<br class="d-md-none d-xxl-block" />storage bank</h1>
                                        <p class="card-text">Sistem Informasi Ormawa memudahkan pengelolaan data, dokumentasi kegiatan, dan publikasi informasi organisasi mahasiswa secara aman, efisien, dan terpusat.</p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- end of .container-->
        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->

        <!-- Map Section -->
        <section class="py-4">
            <div class="container-lg bg-info p-4 rounded-3">
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <h2 class="text-light fw-bold">Lokasi Kampus</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============================================-->
        <!-- <section> begin ============================-->
        <section class="py-6 pb-0">
            <div class="container">
                <div class="row justify-content-lg-around">
                    <div class="col-12 col-sm-12 col-lg-3 mb-4 order-0 order-sm-0">
                        <a class="text-decoration-none" href="#">
                            <img class="img-fluid me-3" src="{{ asset('landingpage/assets/img/icons/poltek.png') }}" alt="" style="max-width: 80px;" />
                            <span class="fw-bold fs-1 text-1000">SiOrmawa</span>
                        </a>
                        <p class="mt-4">Politeknik <br />Harapan Bersama</p>
                        <p>poltekharber.ac.id<br />(0283) 352000 </p>
                    </div>
                    <div class="col-12 col-sm-4 col-lg-3 mb-3 order-1 order-sm-3">
                        <h6 class="lh-lg fw-bold mb-4">Social Media </h6>
                        <ul class="list-unstyled mb-md-4 mb-lg-0">
                            <li class="list-inline-item">
                                <a class="text-dark fs--1 text-decoration-none" href="https://web.facebook.com/poltekharber.fanspage">
                                    <img class="img-fluid" src="{{ asset('landingpage/assets/img/icons/f.png') }}" width="40" alt="" />
                                </a>Facebook
                            </li>
                            <li class="list-inline-item">
                                <a class="text-dark fs--1 text-decoration-none" href="https://x.com/poltek_harber">
                                    <img class="img-fluid" src="{{ asset('landingpage/assets/img/icons/t.png') }}" width="40" alt="" />
                                </a>Twitter
                            </li>
                            <li class="list-inline-item">
                                <a class="text-dark fs--1 text-decoration-none" href="https://www.instagram.com/poltek_harber/">
                                    <img class="img-fluid" src="{{ asset('landingpage/assets/img/icons/i.png') }}" width="40" alt="" />
                                </a>Instagram
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- end of .container-->
        </section>
        <!-- <section> close ============================-->
        <!-- ============================================-->

        <!-- ============================================-->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                background-color: #f5f5f5;
            }

            .header {
                background-color: #1a5276;
                color: white;
                padding: 20px 0;
                text-align: center;
            }

            .logo {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 10px;
            }

            .logo-placeholder {
                width: 60px;
                height: 60px;
                background-color: #ffffff;
                border-radius: 50%;
                margin-right: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: #1a5276;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .map-section {
                margin: 30px 0;
                text-align: center;
            }

            .map-section h2 {
                margin-bottom: 20px;
                color: #1a5276;
            }

            #map {
                height: 500px;
                width: 100%;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0 .1);
            }

            .info-window {
                padding: 10px;
            }

            .info-window h3 {
                margin-bottom: 5px;
                color: #1a5276;
            }

            .info-window p {
                margin-bottom: 5px;
            }

            .footer {
                background-color: #1a5276;
                color: white;
                text-align: center;
                padding: 20px 0;
                margin-top: 30px;
            }

            .contact-info {
                margin-top: 10px;
            }
        </style>
        <!-- <section> close ============================-->
        <!-- ============================================-->

    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('landingpage/vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landingpage/vendors/is/is.min.js') }}"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="{{ asset('landingpage/assets/js/theme.js') }}"></script>

    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,700;1,900&amp;display=swap" rel="stylesheet">
    <!-- Leaflet JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Koordinat Politeknik Harapan Bersama (Tegal, Jawa Tengah)
            const phbCoords = [-6.8697881, 109.1040696];

            // Inisialisasi peta
            const map = L.map('map').setView(phbCoords, 15);

            // Tambahkan layer OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker untuk lokasi PHB
            const marker = L.marker(phbCoords).addTo(map);

            // Tambahkan popup ke marker
            marker.bindPopup(`
                <div class="info-window">
                    <h3>Politeknik Harapan Bersama</h3>
                    <p>Jl. Mataram No.9, Pesurungan Lor, Kec. Margadana, Kota Tegal, Jawa Tengah 52147</p>
                    <p>Telepon: (0283) 352000</p>
                    <p><a href="https://poltektegal.ac.id" target="_blank">Website Resmi</a></p>
                </div>
            `).openPopup();

            // Tambahkan circle untuk menunjukkan area kampus
            L.circle(phbCoords, {
                color: '#1a5276',
                fillColor: '#2980b9',
                fillOpacity: 0.2,
                radius: 150 // radius dalam meter
            }).addTo(map);
        });
    </script>
</body>

</html>