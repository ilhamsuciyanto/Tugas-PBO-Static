<?php
// ============================================
// TUGAS PRAKTIKUM 2 - Static Method
// ============================================

class Matematika {
    public static function tambah($a, $b) {
        return $a + $b;
    }

    public static function kurang($a, $b) {
        return $a - $b;
    }

    public static function kali($a, $b) {
        return $a * $b;
    }

    public static function bagi($a, $b) {
        if ($b == 0) {
            return "Error: Tidak bisa dibagi 0!";
        }
        return $a / $b;
    }

    public static function luasPersegi($sisi) {
        return $sisi * $sisi;
    }
}

// Ambil nilai dari form jika ada
$angka1  = isset($_POST['angka1'])  ? (float)$_POST['angka1']  : 0;
$angka2  = isset($_POST['angka2'])  ? (float)$_POST['angka2']  : 0;
$sisi    = isset($_POST['sisi'])    ? (float)$_POST['sisi']    : 0;
$operasi = isset($_POST['operasi']) ? $_POST['operasi']        : '';

$hasil = null;
$hasilPersegi = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah operasi yang diklik adalah kalkulator dasar
    if (in_array($operasi, ['tambah', 'kurang', 'kali', 'bagi'])) {
        switch ($operasi) {
            case 'tambah': $hasil = Matematika::tambah($angka1, $angka2); break;
            case 'kurang': $hasil = Matematika::kurang($angka1, $angka2); break;
            case 'kali':   $hasil = Matematika::kali($angka1, $angka2);   break;
            case 'bagi':   $hasil = Matematika::bagi($angka1, $angka2);   break;
        }
    } 
    // Cek apakah operasi yang diklik adalah luas persegi
    elseif ($operasi === 'persegi') {
        if ($sisi > 0) {
            $hasilPersegi = Matematika::luasPersegi($sisi);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Matematika - OOP</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 480px;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        h1 { font-size: 24px; font-weight: 800; color: #60a5fa; margin-bottom: 5px; text-align: center; }
        .subtitle { font-size: 13px; color: #94a3b8; text-align: center; margin-bottom: 30px; }
        .section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; margin: 25px 0 10px; }
        
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px; }
        label { display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; color: #cbd5e1; margin-bottom: 8px; }
        input[type="number"] {
            width: 100%; padding: 12px 15px; background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px; color: white;
            font-size: 16px; font-family: 'Courier New', monospace; outline: none; transition: 0.3s;
        }
        input[type="number"]:focus { border-color: #60a5fa; background: rgba(96, 165, 250, 0.1); box-shadow: 0 0 0 3px rgba(96,165,250,0.2); }
        
        .btn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        button {
            padding: 12px; border-radius: 10px; border: none; font-size: 14px; font-weight: 700;
            cursor: pointer; transition: 0.2s; color: white; display: flex; justify-content: center; align-items: center; gap: 5px;
        }
        button:hover { transform: translateY(-2px); filter: brightness(1.1); }
        button:active { transform: translateY(0); }
        
        .btn-tambah { background: #059669; }
        .btn-kurang { background: #dc2626; }
        .btn-kali   { background: #d97706; }
        .btn-bagi   { background: #2563eb; }
        .btn-persegi { width: 100%; background: #7c3aed; margin-top: 10px; }

        .hasil-box {
            background: rgba(96, 165, 250, 0.1); border: 1px solid rgba(96, 165, 250, 0.3);
            border-radius: 12px; padding: 20px; margin-top: 25px; text-align: center;
        }
        .hasil-box.purple { background: rgba(167, 139, 250, 0.1); border-color: rgba(167, 139, 250, 0.3); }
        .hasil-label { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .hasil-angka { font-size: 42px; font-weight: 900; font-family: 'Courier New', monospace; margin: 5px 0; color: #60a5fa; }
        .hasil-box.purple .hasil-angka { color: #a78bfa; }
        .hasil-detail { font-size: 13px; color: #cbd5e1; }
    </style>
</head>
<body>
<div class="container">
    <h1>🧮 Kalkulator OOP</h1>
    <div class="subtitle">PHP Static Method</div>

    <form method="POST">
        <div class="section-title">Operasi Hitung</div>
        <div class="input-row">
            <div>
                <label>Angka 1</label>
                <input type="number" name="angka1" value="<?= $angka1 ?>" step="any" placeholder="0">
            </div>
            <div>
                <label>Angka 2</label>
                <input type="number" name="angka2" value="<?= $angka2 ?>" step="any" placeholder="0">
            </div>
        </div>

        <div class="btn-grid">
            <button type="submit" name="operasi" value="tambah" class="btn-tambah">➕ Tambah</button>
            <button type="submit" name="operasi" value="kurang" class="btn-kurang">➖ Kurang</button>
            <button type="submit" name="operasi" value="kali" class="btn-kali">✖️ Kali</button>
            <button type="submit" name="operasi" value="bagi" class="btn-bagi">➗ Bagi</button>
        </div>
    </form>

    <?php if ($hasil !== null && in_array($operasi, ['tambah', 'kurang', 'kali', 'bagi'])): 
        $simbols = ['tambah'=>'+', 'kurang'=>'-', 'kali'=>'×', 'bagi'=>'÷'];
        $simbol = $simbols[$operasi];
    ?>
    <div class="hasil-box">
        <div class="hasil-label">Hasil <?= ucfirst($operasi) ?></div>
        <div class="hasil-angka"><?= is_numeric($hasil) ? round($hasil, 4) : $hasil ?></div>
        <div class="hasil-detail"><?= $angka1 ?> <?= $simbol ?> <?= $angka2 ?> = <?= $hasil ?></div>
    </div>
    <?php endif; ?>

    <form method="POST">
        <div class="section-title">Luas Persegi</div>
        <div style="margin-bottom: 10px;">
            <label>Panjang Sisi</label>
            <input type="number" name="sisi" value="<?= $sisi ?>" min="0" step="any" placeholder="Masukkan sisi...">
        </div>
        <button type="submit" name="operasi" value="persegi" class="btn-persegi">🔲 Hitung Luas Persegi</button>
    </form>

    <?php if ($hasilPersegi !== null && $operasi === 'persegi'): ?>
    <div class="hasil-box purple">
        <div class="hasil-label">Luas Persegi</div>
        <div class="hasil-angka"><?= round($hasilPersegi, 4) ?></div>
        <div class="hasil-detail">Sisi × Sisi (<?= $sisi ?> × <?= $sisi ?>) = <?= $hasilPersegi ?></div>
    </div>
    <?php endif; ?>

</div>
</body>
</html>