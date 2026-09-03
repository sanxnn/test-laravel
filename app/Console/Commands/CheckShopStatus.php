<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('pos:status {jam?}')]
#[Description('Mengecek status operasional toko')]
class CheckShopStatus extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $namaKasir = $this->ask('Masukkan nama kasir') ?? 'User';
        $jam = $this->argument('jam') ?? 10;

        $this->info('=== MONITORING STATUS TOKO ===');

        if ($jam >= 9 && $jam <= 20) {
            $this->info("Halo $namaKasir, toko saat ini BUKA.");
            $this->comment('Kasir dapat melayani transaksi pelanggan.');
        } elseif ($jam >= 24 || $jam < 0) {
            $this->error('Jam yang dimasukkan tidak valid. Gunakan 00 - 23.');
        } else {
            $this->warn("Halo $namaKasir, toko saat ini TUTUP.");
            $this->comment('Transaksi tidak dapat dilakukan saat toko tutup.');
        }

        return Command::SUCCESS;
    }
}
