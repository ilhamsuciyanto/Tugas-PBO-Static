<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Produk - Terminal View</title>
    <style>
        body {
            background-color: #121212;
            color: #a7f3d0; /*  tambahin desain aja biar bagus walaupun dengan bantuan AI*/
            font-family: 'Consolas', 'Courier New', monospace;
            display: flex;
            justify-content: center;
            padding: 40px 20px;
            margin: 0;
        }
        .terminal-container {
            background-color: #0a0a0a;
            border: 1px solid #333;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.8), 0 0 15px rgba(16, 185, 129, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 650px;
            overflow-x: auto;
        }
        .header-mac {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #333;
        }
        .dot {
            width: 12px; height: 12px; border-radius: 50%;
        }
        .dot.red { background-color: #ef4444; }
        .dot.yellow { background-color: #f59e0b; }
        .dot.green { background-color: #10b981; }
        
        pre {
            margin: 0;
            font-size: 14.5px;
            line-height: 1.6;
            color: #d1d5db;
        }
        .highlight { color: #60a5fa; font-weight: bold; } /* Biru */
        .success { color: #34d399; font-weight: bold; } /* Hijau */
        .warning { color: #fbbf24; font-weight: bold; } /* Kuning */
        .receipt { color: #f87171; font-weight: bold; } /* Merah muda */
    </style>
</head>
<body>

<div class="terminal-container">
    <div class="header-mac">
        <div class="dot red"></div>
        <div class="dot yellow"></div>
        <div class="dot green"></div>
    </div>
<pre>
<?php

class Produk {


    public static $jumlahProduk = 0;

    private string $nama;
    private float  $harga;
    private int    $stok;

    public function __construct(string $nama, float $harga, int $stok) {
        $this->nama  = $nama;
        $this->harga = $harga;
        $this->stok  = $stok;
        self::$jumlahProduk++; 
    }

    public function tambahProduk(int $jumlah): void {
        $this->stok += $jumlah;
        echo "<span class='success'>[+] Stok {$this->nama} bertambah {$jumlah}. Stok sekarang: {$this->stok}</span>" . PHP_EOL;
    }

    public function getNama():  string { return $this->nama;  }
    public function getHarga(): float  { return $this->harga; }
    public function getStok():  int    { return $this->stok;  }

    public function kurangiStok(int $jumlah): bool {
        if ($this->stok < $jumlah) return false;
        $this->stok -= $jumlah;
        return true;
    }

    public function formatHarga(): string {
        return "Rp " . number_format($this->harga, 0, ',', '.');
    }
}


class Transaksi {

    private array $keranjang = [];
    private float $totalBayar = 0;

    public function tambahKeKeranjang(Produk $produk, int $qty): void {
        $this->keranjang[] = [
            'produk' => $produk,
            'qty'    => $qty,
            'subtotal' => $produk->getHarga() * $qty
        ];
        $this->totalBayar += $produk->getHarga() * $qty;
    }

    
    final public function prosesTransaksi(): void {
        echo PHP_EOL . "<span class='receipt'>==================================================</span>" . PHP_EOL;
        echo "<span class='receipt'>                 🧾 STRUK TRANSAKSI               </span>" . PHP_EOL;
        echo "<span class='receipt'>==================================================</span>" . PHP_EOL;

        foreach ($this->keranjang as $item) {
            $produk = $item['produk'];
            $ok = $produk->kurangiStok($item['qty']);

            if ($ok) {
                printf("%-30s x%-3d <span class='success'>%s</span>\n",
                    $produk->getNama(),
                    $item['qty'],
                    "Rp " . number_format($item['subtotal'], 0, ',', '.')
                );
            } else {
                echo "❌ GAGAL: Stok {$produk->getNama()} tidak cukup!" . PHP_EOL;
                $this->totalBayar -= $item['subtotal'];
            }
        }

        echo "<span class='receipt'>--------------------------------------------------</span>" . PHP_EOL;
        echo "TOTAL BAYAR  :  <span class='warning'>Rp " . number_format($this->totalBayar, 0, ',', '.') . "</span>" . PHP_EOL;
        echo "STATUS       :  <span class='success'>✅ TRANSAKSI BERHASIL</span>"  . PHP_EOL;
        echo "<span class='receipt'>==================================================</span>" . PHP_EOL;
    }
}

class TransaksiOnline extends Transaksi {
    private string $metodePembayaran;

    public function __construct(string $metode) {
        $this->metodePembayaran = $metode;
    }

    public function infoMetode(): void {
        echo "<span class='highlight'>Metode Pembayaran: " . $this->metodePembayaran . "</span>" . PHP_EOL;
    }
}



$laptop   = new Produk("Laptop Asus VivoBook", 8500000, 10);
$mouse    = new Produk("Mouse Wireless Logitech", 250000, 50);
$keyboard = new Produk("Keyboard Mechanical", 650000, 25);
$headset  = new Produk("Headset Gaming", 450000, 15);

echo "<span class='highlight'>==================================================</span>" . PHP_EOL;
echo "<span class='highlight'>                 📦 DAFTAR PRODUK                 </span>" . PHP_EOL;
echo "<span class='highlight'>==================================================</span>" . PHP_EOL;

$semuaProduk = [$laptop, $mouse, $keyboard, $headset];
foreach ($semuaProduk as $i => $p) {
    printf("%d. %-30s %-18s Stok: <span class='warning'>%d</span>\n",
        $i + 1,
        $p->getNama(),
        $p->formatHarga(),
        $p->getStok()
    );
}

echo "<span class='highlight'>--------------------------------------------------</span>" . PHP_EOL;
echo "Total Jenis Produk: <span class='warning'>" . Produk::$jumlahProduk . "</span>" . PHP_EOL;
echo "<span class='highlight'>==================================================</span>" . PHP_EOL;


echo PHP_EOL . "<span class='highlight'>[ PROSES INVENTORY ]</span>" . PHP_EOL;
$mouse->tambahProduk(20);


echo PHP_EOL . "<span class='highlight'>[ MEMULAI TRANSAKSI ]</span>" . PHP_EOL;
$trx = new TransaksiOnline("Transfer Bank BRI");
$trx->tambahKeKeranjang($laptop,   1);
$trx->tambahKeKeranjang($mouse,    2);
$trx->tambahKeKeranjang($headset,  1);

$trx->infoMetode();
$trx->prosesTransaksi(); 


echo PHP_EOL . "<span class='highlight'>📊 STOK SETELAH TRANSAKSI:</span>" . PHP_EOL;
foreach ($semuaProduk as $p) {
    echo "- {$p->getNama()}: <span class='warning'>{$p->getStok()} unit</span>" . PHP_EOL;
}

echo PHP_EOL . "Total Jenis Produk (Static Property): <span class='warning'>" . Produk::$jumlahProduk . "</span>" . PHP_EOL;

?>
</pre>
</div>

</body>
</html>