<?php
include 'koneksi.php';
include 'header.php';
?>

<!-- Header Banner -->
<section class="py-5 text-center" style="background: linear-gradient(135deg, #fff5f6 0%, #ffeef1 100%);">
    <div class="container py-4">
        <h1 class="display-4 fw-bold display-font mb-3">Hubungi Kami</h1>
        <p class="lead text-secondary max-width-600 mx-auto">Kami siap membantu mewujudkan rangkaian bunga impian Anda. Hubungi kami kapan saja.</p>
    </div>
</section>

<!-- Konten Utama -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Kolom Informasi Kontak (Kiri) -->
        <div class="col-lg-5">
            <h3 class="display-font fw-bold mb-4" style="font-size: 1.8rem;">Informasi Toko</h3>
            <p class="text-secondary mb-4">Punya pertanyaan seputar kustomisasi bunga, pemesanan jumlah besar, atau pengiriman? Hubungi kami langsung melalui kontak di bawah ini.</p>
            
            <div class="d-flex align-items-start mb-4">
                <div class="contact-icon-box">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Alamat Galeri</h5>
                    <p class="text-secondary mb-0">Jl. Mawar Indah No. 12, Kebon Jeruk, Jakarta Barat, 11530</p>
                </div>
            </div>

            <div class="d-flex align-items-start mb-4">
                <div class="contact-icon-box">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Telepon / WhatsApp</h5>
                    <p class="text-secondary mb-0">+62 812-3456-7890</p>
                </div>
            </div>

            <div class="d-flex align-items-start mb-4">
                <div class="contact-icon-box">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Email Resmi</h5>
                    <p class="text-secondary mb-0">info@samslepflor.com</p>
                </div>
            </div>

            <div class="d-flex align-items-start mb-4">
                <div class="contact-icon-box">
                    <i class="bi bi-clock-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Jam Operasional</h5>
                    <p class="text-secondary mb-0">Senin - Minggu: 08:00 - 20:00 WIB</p>
                </div>
            </div>
        </div>

        <!-- Kolom Form Kontak (Kanan) -->
        <div class="col-lg-7">
            <div class="form-card">
                <h3 class="display-font fw-bold mb-4" style="font-size: 1.8rem;">Kirim Pesan</h3>
                
                <form id="contactForm" onsubmit="event.preventDefault(); handleContactSubmit();">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="subjek">Subjek Pesan</label>
                            <input type="text" class="form-control" id="subjek" placeholder="Contoh: Tanya Custom Bouquet" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="pesan">Pesan Anda</label>
                            <textarea class="form-control" id="pesan" rows="5" placeholder="Tuliskan detail pertanyaan atau pesan Anda di sini..." required></textarea>
                        </div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function handleContactSubmit() {
    Swal.fire({
        title: 'Berhasil!',
        text: 'Pesan Anda telah berhasil terkirim. Tim SamslepFlor akan segera menghubungi Anda kembali.',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#ff6f91'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('contactForm').reset();
        }
    });
}
</script>

<?php
include 'footer.php';
?>
