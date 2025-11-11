<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Praktikum 7 | Pemrosesan Data Karyawan</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f9; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); }
        h2, h3 { color: #0056b3; border-bottom: 2px solid #0056b3; padding-bottom: 5px; margin-top: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        input[type="text"], input[type="date"], select { width: calc(100% - 10px); padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; }
        button { background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; margin-top: 10px; transition: background-color 0.3s; }
        button:hover { background-color: #218838; }
        .result { background-color: #e9ecef; border-left: 5px solid #0056b3; padding: 15px; margin-top: 20px; border-radius: 6px; }
        .demo-output { background-color: #fff3cd; border: 1px solid #ffeeba; color: #856404; padding: 10px; margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        
        <h2>Informasi Mahasiswa</h2>
        <?php
            // Deklarasi Variabel
            $nama_mhs = "Sayidina Ramadhan"; // Diganti agar tidak sama dengan nama Anda
            $nim_mhs = 312410112;
            $matkul = "Pemrograman Web1";
        ?>
        <p><strong>Nama:</strong> <?= $nama_mhs ?></p>
        <p><strong>NIM:</strong> <?= $nim_mhs ?></p>
        <p><strong>Mata Kuliah:</strong> <?= $matkul ?></p>
        
        <h2>Form Tugas Akhir</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="tgl_lahir">Tanggal Lahir:</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" required>
            </div>
            <div class="form-group">
                <label for="pekerjaan">Pilih Pekerjaan:</label>
                <select id="pekerjaan" name="pekerjaan" required>
                    <option value="">-- Pilih Pekerjaan --</option>
                    <option value="manager">Manager Proyek</option>
                    <option value="staff">Staf Administrasi</option>
                    <option value="teknisi">Teknisi Lapangan</option>
                    <option value="magang">Anak Magang</option>
                </select>
            </div>
            <button type="submit" name="submit_data">Proses Data</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_data'])) {
            $nama = htmlspecialchars($_POST['nama']);
            $tgl_lahir_str = $_POST['tgl_lahir'];
            $pekerjaan = $_POST['pekerjaan'];
            
            // --- 1. Perhitungan Umur ---
            $tgl_lahir_obj = new DateTime($tgl_lahir_str);
            $sekarang = new DateTime();
            $umur = $sekarang->diff($tgl_lahir_obj)->y;
            
            // --- 2. Penentuan Gaji Variatif menggunakan Array dan Kondisi Ternary ---
            
            // Data Gaji (menggunakan Array Asosiatif)
            $data_gaji = [
                'manager' => 12000000,
                'staff' => 5500000,
                'teknisi' => 7000000,
                'magang' => 1500000
            ];
            
            // Mengambil gaji dari array, jika tidak ditemukan default ke 0 (menggunakan isset)
            $gaji = isset($data_gaji[$pekerjaan]) ? $data_gaji[$pekerjaan] : 0;
            
            // Memberikan label pekerjaan yang lebih baik untuk ditampilkan
            $pekerjaan_label = [
                'manager' => 'Manager Proyek',
                'staff' => 'Staf Administrasi',
                'teknisi' => 'Teknisi Lapangan',
                'magang' => 'Anak Magang'
            ];
            $display_pekerjaan = isset($pekerjaan_label[$pekerjaan]) ? $pekerjaan_label[$pekerjaan] : 'Data Tidak Valid';

            echo '<div class="result">';
            echo '<h3>Hasil Pemrosesan Data</h3>';
            echo "<p><strong>Nama:</strong> $nama</p>";
            echo "<p><strong>Tanggal Lahir:</strong> $tgl_lahir_str</p>";
            echo "<p><strong>Umur Anda:</strong> $umur tahun</p>";
            echo "<p><strong>Pekerjaan:</strong> $display_pekerjaan</p>";
            echo "<p><strong>Gaji Pokok:</strong> Rp. " . number_format($gaji, 0, ',', '.') . "</p>";
            
            // --- Demonstrasi Kondisi IF-ELSE (Bonus Gaji berdasarkan Pekerjaan) ---
            $bonus = 0;
            if ($pekerjaan === 'manager') {
                $bonus = 500000;
            } elseif ($pekerjaan === 'teknisi' || $pekerjaan === 'staff') {
                // Contoh penggunaan operator OR
                $bonus = 200000;
            } else {
                $bonus = 0;
            }
            $gaji_total = $gaji + $bonus;
            
            echo "<p><strong>Bonus Khusus:</strong> Rp. " . number_format($bonus, 0, ',', '.') . "</p>";
            echo "<p><strong>GAJI TOTAL (Gaji + Bonus):</strong> Rp. " . number_format($gaji_total, 0, ',', '.') . "</p>";
            echo '</div>';
        }
        ?>
        
        <h3>Demonstrasi Konsep PHP Dasar</h3>
        
        <div class="demo-output">
            <h4>Operator Aritmatika & Kondisi Sederhana (Ternary Operator)</h4>
            <?php
            $harga_barang = 150000;
            $status_member = true;
            // Kondisi Ternary: $diskon = (kondisi) ? nilai_jika_true : nilai_jika_false;
            $diskon = $status_member ? 0.1 : 0; // Diskon 10% jika member
            $harga_bersih = $harga_barang - ($harga_barang * $diskon);
            
            echo "<p>Harga Barang: Rp. " . number_format($harga_barang, 0, ',', '.') . "</p>";
            echo "<p>Diskon Member: " . ($diskon * 100) . "%</p>";
            echo "<p>Harga Akhir: Rp. " . number_format($harga_bersih, 0, ',', '.') . "</p>";
            ?>
        </div>
        
        <div class="demo-output">
            <h4>Perulangan FOR (Angka Genap)</h4>
            <?php
            echo "Deret Angka Genap dari 2 sampai 10: ";
            $output_for = [];
            for ($k = 2; $k <= 10; $k += 2) {
                $output_for[] = $k;
            }
            echo implode(", ", $output_for);
            ?>
        </div>

        <div class="demo-output">
            <h4>Perulangan DO-WHILE (Perkalian 3)</h4>
            <?php
            echo "Deret Perkalian 3 (sampai batas 20): <br>";
            $l = 3;
            do {
                echo "Nilai ke-$l <br>";
                $l += 3;
            } while ($l <= 20);
            ?>
        </div>
    </div>
</body>
</html>