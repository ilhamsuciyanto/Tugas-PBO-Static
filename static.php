<?php

class Counter {

    public static $jumlah = 10;

    public function tambah() {
        self::$jumlah--; 
    }
}

$c1 = new Counter();
$c2 = new Counter();

$c1->tambah(); 

echo Counter::$jumlah; 
// Otput yang dihasilkan 8 sebenarnya bukan jumlah sih sama kok hasil otputnyaa

?>

