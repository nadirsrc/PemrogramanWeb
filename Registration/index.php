<?php
// --- KONEKSI DATABASE ---
$host = "localhost";
$user = "root";     // Default user XAMPP
$pass = "";         // Default password XAMPP (kosong)
$db   = "lomba";    // Nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$pesan_sukses = "";
$pesan_error = "";

// --- PROSES FORM JIKA DISUBMIT ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $tgl_lahir  = mysqli_real_escape_string($conn, $_POST['tgl_lahir']);
    $gender     = mysqli_real_escape_string($conn, $_POST['gender']);
    $lomba      = mysqli_real_escape_string($conn, $_POST['lomba']);
    $sekolah    = mysqli_real_escape_string($conn, $_POST['sekolah']);
    $whatsapp   = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Query Insert ke Database
    $sql = "INSERT INTO pendaftaranlomba (nama, email, tgl_lahir, gender, lomba, sekolah, whatsapp, alamat) 
            VALUES ('$nama', '$email', '$tgl_lahir', '$gender', '$lomba', '$sekolah', '$whatsapp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        $pesan_sukses = "Pendaftaran berhasil! Silakan cek WhatsApp Anda.";

        // --- INTEGRASI FONNTE (Kirim WA) ---
        // Masukkan Token Fonnte kamu di sini
        $token_fonnte = "bUGA7BKV2w4MjEeNoVwN"; 

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array(
            'target' => $whatsapp, // Mengirim pesan ke nomor pendaftar
            'message' => "Halo *$nama*,\n\nTerima kasih telah mendaftar. Berikut detail data Anda:\n\n*Nama:* $nama\n*Email:* $email\n*Tgl Lahir:* $tgl_lahir\n*Gender:* $gender\n*Lomba:* $lomba\n*Sekolah:* $sekolah\n*Alamat:* $alamat\n\nData Anda sudah kami simpan di database.\nSemangat Lombanya!", 
          ),
          CURLOPT_HTTPHEADER => array(
            "Authorization: $token_fonnte"
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // -----------------------------------

    } else {
        $pesan_error = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Lomba</title>
    <!-- Menggunakan Tailwind CSS lewat CDN biar tampilan mirip gambar tanpa ribet CSS manual -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom style untuk field date biar rapi */
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10 px-4">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Form Pendaftaran</h2>

        <?php if ($pesan_sukses): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $pesan_sukses; ?></span>
            </div>
        <?php endif; ?>

        <?php if ($pesan_error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $pesan_error; ?></span>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-4">
                <label for="tgl_lahir" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Lahir</label>
                <input type="date" id="tgl_lahir" name="tgl_lahir" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
            </div>

            <!-- Gender -->
            <div class="mb-4">
                <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender</label>
                <select id="gender" name="gender" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 bg-white">
                    <option value="" disabled selected>-- Pilih Gender --</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <!-- Lomba -->
            <div class="mb-4">
                <label for="lomba" class="block text-gray-700 text-sm font-bold mb-2">Lomba</label>
                <select id="lomba" name="lomba" required class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 bg-white">
                    <option value="" disabled selected>-- Pilih Lomba --</option>
                    <option value="Coding">Coding</option>
                    <option value="Desain Grafis">Desain Grafis</option>
                    <option value="Mobile Legend">Mobile Legend</option>
                </select>
            </div>

            <!-- Sekolah -->
            <div class="mb-4">
                <label for="sekolah" class="block text-gray-700 text-sm font-bold mb-2">Sekolah</label>
                <input type="text" id="sekolah" name="sekolah" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
            </div>

            <!-- WhatsApp -->
            <div class="mb-4">
                <label for="whatsapp" class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp</label>
                <input type="number" id="whatsapp" name="whatsapp" placeholder="Contoh: 081234567890" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500">
            </div>

            <!-- Alamat -->
            <div class="mb-6">
                <label for="alamat" class="block text-gray-700 text-sm font-bold mb-2">Alamat</label>
                <textarea id="alamat" name="alamat" placeholder="Masukkan alamat" required rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500"></textarea>
            </div>

            <!-- Tombol Daftar -->
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    Daftar
                </button>
            </div>
        </form>
    </div>

</body>
</html>
