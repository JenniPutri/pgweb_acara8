<?php
    // Menghubungkan ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pgweb_acara8";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Memeriksa apakah form telah di-submit dan semua nilai tersedia
    if (isset($_POST['kecamatan'], $_POST['longitude'], $_POST['latitude'], $_POST['luas'], $_POST['jumlah_penduduk'])) {
        // Mengambil nilai dan mengamankan dari SQL Injection
        $kecamatan = mysqli_real_escape_string($conn, $_POST['kecamatan']);
        $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
        $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
        $luas = mysqli_real_escape_string($conn, $_POST['luas']);
        $jumlah_penduduk = mysqli_real_escape_string($conn, $_POST['jumlah_penduduk']);

        // Query untuk memasukkan data ke tabel
        $sql = "INSERT INTO acara8 (kecamatan, longitude, latitude, luas, jumlah_penduduk) 
                VALUES ('$kecamatan', '$longitude', '$latitude', '$luas', '$jumlah_penduduk')";

        // Eksekusi query
        if ($conn->query($sql) === TRUE) {
            echo "Data berhasil ditambahkan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Form tidak lengkap. Silakan isi semua data.";
    }

    // Menutup koneksi
    $conn->close();
?>
