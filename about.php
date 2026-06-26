<?php
include 'koneksi.php';
include 'header.php';
?>

<!-- Header Banner -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, #fff5f6 0%, #ffeef1 100%);">
    <div class="container py-4">
        <h1 class="display-4 fw-bold display-font mb-3">Tentang SamslepFlor</h1>
        <p class="lead text-secondary max-width-600 mx-auto">Mengenal lebih dekat florist pilihan terbaik untuk menyempurnakan hari bahagia Anda.</p>
    </div>
</section>

<!-- Konten Utama -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <!-- Kolom Visual -->
            <div class="col-lg-6">
                <div class="position-relative mx-auto" style="max-width: 400px; aspect-ratio: 1/1;">
                    <!-- Beautiful CSS abstract arrangement -->
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle" style="background: linear-gradient(135deg, #ffeef2 0%, #ffd3b6 100%); z-index: 1;"></div>
                    <div class="position-absolute d-flex flex-column align-items-center justify-content-center text-center shadow-lg rounded-4 p-4" style="background: white; border: 8px solid white; width: 320px; height: 320px; top: 40px; left: 40px; z-index: 2;">
                        <span style="font-size: 5rem;" class="mb-2">🌸</span>
                        <h4 class="fw-bold display-font">Sejak 2026</h4>
                        <p class="text-muted mb-0 small">Merangkai kebahagiaan & cinta lewat keindahan mahkota bunga.</p>
                    </div>
                </div>
            </div>

            <!-- Kolom Teks -->
            <div class="col-lg-6">
                <h2 class="display-font fw-bold mb-4" style="font-size: 2.2rem;">Kisah Di Balik Setiap Rangkaian Bunga Kami</h2>
                <p class="text-secondary mb-3" style="line-height: 1.8;">
                    <strong>SamslepFlor</strong> didirikan atas dasar kecintaan yang mendalam pada seni merangkai bunga. Kami percaya bahwa bunga bukan sekadar tanaman hias, melainkan sebuah pesan emosional universal yang melambangkan kasih sayang, kepedulian, kebahagiaan, dan bahkan simpati terdalam.
                </p>
                <p class="text-secondary mb-4" style="line-height: 1.8;">
                    Setiap tangkai bunga yang kami gunakan dipilih langsung dari perkebunan lokal terbaik demi memastikan tingkat kesegaran tertinggi saat tiba di tangan penerima. Dipadukan dengan keahlian florist profesional kami, setiap rangkaian diciptakan secara unik, presisi, dan penuh penjiwaan estetis.
                </p>
                
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon-box m-0 me-3">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Rangkaian Kasih</h5>
                                <p class="text-muted small mb-0">Dibuat dengan sepenuh hati</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="contact-icon-box m-0 me-3">
                                <i class="bi bi-shield-fill-check"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Kualitas Terjamin</h5>
                                <p class="text-muted small mb-0">Bunga segar pilihan terbaik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-4 justify-content-center text-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100" style="background-color: var(--white);">
                    <span class="fs-1 text-primary mb-3 d-inline-block"><i class="bi bi-eye-fill"></i></span>
                    <h3 class="fw-bold display-font mb-3">Visi Kami</h3>
                    <p class="text-secondary mb-0">
                        Menjadi florist premium terpercaya yang menginspirasi kebahagiaan dan menyambung tali silaturahmi masyarakat lewat keindahan seni rangkaian bunga berkualitas tinggi.
                    </p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 p-5 h-100" style="background-color: var(--white);">
                    <span class="fs-1 text-primary mb-3 d-inline-block"><i class="bi bi-compass-fill"></i></span>
                    <h3 class="fw-bold display-font mb-3">Misi Kami</h3>
                    <p class="text-secondary mb-0 text-start">
                        1. Konsisten menghadirkan produk bunga segar pilihan segar setiap harinya.<br>
                        2. Memberikan pelayanan ramah, responsif, dan pengiriman yang aman serta tepat waktu.<br>
                        3. Terus berinovasi menciptakan desain rangkaian bunga yang relevan dengan tren dan selera pasar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>
