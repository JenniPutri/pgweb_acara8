<?php
// Buat koneksi ke database
$conn = new mysqli("localhost", "root", "", "pgweb_acara8");

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pesan status untuk penghapusan
$message = '';

// Periksa apakah tindakan penghapusan di-trigger
if (isset($_GET['delete_id'])) {
    // Gunakan kecamatan sebagai parameter delete karena tidak ada ID
    $delete_kecamatan = $_GET['delete_id'];
    
    // Siapkan query delete berdasarkan nama kecamatan
    $delete_sql = "DELETE FROM acara8 WHERE kecamatan = ? LIMIT 1";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $delete_kecamatan);
    
    if ($stmt->execute()) {
        $message = "<div style='color: green; margin: 10px 0;'>Data kecamatan " . htmlspecialchars($delete_kecamatan) . " berhasil dihapus!</div>";
    } else {
        $message = "<div style='color: red; margin: 10px 0;'>Error menghapus data: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Tampilkan pesan jika ada
echo $message;

// Kueri untuk mendapatkan data dari tabel
$sql = "SELECT * FROM acara8";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1px' cellpadding='5' cellspacing='0'>
            <tr style='background-color: #f2f2f2;'>
                <th>Kecamatan</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Luas</th>
                <th>Jumlah Penduduk</th>
                <th>Aksi</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["kecamatan"]) . "</td>
                <td>" . htmlspecialchars($row["longitude"]) . "</td>
                <td>" . htmlspecialchars($row["latitude"]) . "</td>
                <td>" . htmlspecialchars($row["luas"]) . "</td>
                <td align='right'>" . number_format($row["jumlah_penduduk"]) . "</td>
                <td>
                    <form method='GET' style='display: inline;' onsubmit='return confirm(\"Yakin kah dik mau dihapus? " . htmlspecialchars($row["kecamatan"]) . "?\");'>
                        <input type='hidden' name='delete_id' value='" . htmlspecialchars($row["kecamatan"]) . "'>
                        <button type='submit' style='background-color: #ff4444; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;'>Hapus</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>Tidak ada data yang ditemukan.</p>";
}

$conn->close();
?>