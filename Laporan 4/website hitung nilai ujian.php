<!-- Rafi Athaya Rahman -->
<!-- NIM : 202332149 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Mengatur karakter encoding ke UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsif untuk perangkat mobile -->
    <title>Penilaian Mahasiswa</title> <!-- Judul halaman -->

    <!-- Import Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <!-- Import Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <style>
        /* CSS untuk styling */
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5"> <!-- Container utama -->
        <div class="card shadow-sm"> <!-- Card Bootstrap -->
            <div class="card-header text-center"> <!-- Header kartu -->
                <h1 class="h4 mb-0">Form Input Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <!-- Form input data -->
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Anda">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="number" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM Anda">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Nilai Kehadiran 0 - 100" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="Nilai Tugas 0 - 100" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="Nilai UTS 0 - 100" min="0" max="100">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="Nilai UAS 0 - 100" min="0" max="100">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button> <!-- Tombol submit -->
                    </div>
                </form>

                <?php
                // Mengecek apakah tombol proses ditekan
                if (isset($_POST['proses'])) {
                    // Mengambil dan membersihkan input dari form
                    $nama = trim($_POST['nama']);
                    $nim = trim($_POST['nim']);
                    $kehadiran = trim($_POST['kehadiran']);
                    $tugas = trim($_POST['tugas']);
                    $uts = trim($_POST['uts']);
                    $uas = trim($_POST['uas']);

                    // Cek kolom kosong
                    $errors = [];
                    if ($nama == "") $errors[] = "Nama";
                    if ($nim == "") $errors[] = "NIM";
                    if ($kehadiran === "") $errors[] = "Nilai Kehadiran";
                    if ($tugas === "") $errors[] = "Nilai Tugas";
                    if ($uts === "") $errors[] = "Nilai UTS";
                    if ($uas === "") $errors[] = "Nilai UAS";

                    // Jika ada kolom kosong, tampilkan error
                    if (!empty($errors)) {
                        $jumlah_kosong = count($errors);
                        if ($jumlah_kosong <= 2) {
                            $pesan = "Kolom " . implode(" dan ", array_map("ucwords", $errors)) . " harus diisi!";
                        } else {
                            $pesan = "Semua kolom harus diisi!";
                        }

                        // Menampilkan pesan error
                        echo "
                        <div class='alert alert-danger mt-4' role='alert'>
                            $pesan
                        </div>";
                    } else {
                        // Mengubah nilai ke tipe float
                        $kehadiran = (float)$kehadiran;
                        $tugas = (float)$tugas;
                        $uts = (float)$uts;
                        $uas = (float)$uas;

                        // Menghitung nilai akhir
                        $nilai_akhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                        // Menentukan grade berdasarkan nilai akhir
                        if ($nilai_akhir >= 85) {
                            $grade = 'A';
                        } elseif ($nilai_akhir >= 70) {
                            $grade = 'B';
                        } elseif ($nilai_akhir >= 55) {
                            $grade = 'C';
                        } elseif ($nilai_akhir >= 40) {
                            $grade = 'D';
                        } else {
                            $grade = 'E';
                        }

                        // Menentukan status kelulusan
                        if ($kehadiran < 70) {
                            $status = "TIDAK LULUS";
                            $warna = "danger";
                        } elseif ($nilai_akhir >= 60 && $kehadiran > 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
                            $status = "LULUS";
                            $warna = "success";
                        } else {
                            $status = "TIDAK LULUS";
                            $warna = "danger";
                        }

                        // Menampilkan hasil penilaian
                        echo "
                        <div class='mt-4 card border-$warna'>
                            <div class='card-header bg-$warna text-white fw-bold'>
                                Hasil Penilaian
                            </div>
                            <div class='card-body'>
                                <div class='row px-5 fs-4 mb-3'>
                                    <div class='col text-start'><strong>Nama:</strong> $nama</div>
                                    <div class='col text-end'><strong>NIM:</strong> $nim</div>
                                </div>
                                <hr>
                                <p><strong>Nilai Kehadiran:</strong> {$kehadiran}%</p>
                                <p><strong>Nilai Tugas:</strong> $tugas</p>
                                <p><strong>Nilai UTS:</strong> $uts</p>
                                <p><strong>Nilai UAS:</strong> $uas</p>
                                <p><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>
                                <p><strong>Grade:</strong> $grade</p>
                                <p><strong>Status:</strong> <span class='text-" . ($warna == 'success' ? 'success' : 'danger') . "'>$status</span></p>
                            </div>
                            <div class='card-footer bg-$warna text-center'>
                                <button class='btn btn-$warna text-white'>Selesai</button>
                            </div>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>