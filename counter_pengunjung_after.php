<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter Pengunjung - After</title>
    <style>
        body { background-color: #121212; color: #a7f3d0; font-family: 'Consolas', monospace; display: flex; justify-content: center; padding: 40px; }
        .terminal { background-color: #0a0a0a; border: 1px solid #333; border-radius: 12px; padding: 30px; width: 100%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.8); }
        .header-mac { display: flex; gap: 8px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px dashed #333; }
        .dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot.red { background-color: #ef4444; } .dot.yellow { background-color: #f59e0b; } .dot.green { background-color: #10b981; }
        pre { margin: 0; font-size: 15px; line-height: 1.6; color: #d1d5db; }
        .success { color: #34d399; font-weight: bold; }
        .danger { color: #f87171; font-weight: bold; }
        .highlight { color: #60a5fa; font-weight: bold; }
    </style>
</head>
<body>
<div class="terminal">
    <div class="header-mac"><div class="dot red"></div><div class="dot yellow"></div><div class="dot green"></div></div>
<pre>
<?php
class Pengunjung {
    public static $jumlah = 0;

    public function __construct() {
        self::$jumlah++; 
    }

    public static function reset() {
        self::$jumlah = 0;
        echo "<span class='danger'>[!] Memproses reset data...</span>" . PHP_EOL;
    }

    public static function tampilkan() {
        echo "Jumlah Pengunjung: <span class='highlight'>" . self::$jumlah . "</span>" . PHP_EOL;
    }
}

$p1 = new Pengunjung();
$p2 = new Pengunjung();
$p3 = new Pengunjung();
$p4 = new Pengunjung();
$p5 = new Pengunjung();

Pengunjung::reset();

echo PHP_EOL . "<span class='success'>=== SESUDAH RESET ===</span>" . PHP_EOL;
Pengunjung::tampilkan();

?>
</pre>
</div>
</body>
</html>