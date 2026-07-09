<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ExpireOrders extends Command
{
    /**
     * Nama & signature command di artisan.
     *
     * @var string
     */
    protected $signature = 'orders:expire';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Tandai layanan/order yang sudah lewat tanggal expired_at sebagai "expired"';

    public function handle(): int
    {
        $orders = Order::dueForExpiry()->get();

        if ($orders->isEmpty()) {
            $this->info('Tidak ada layanan yang perlu di-expired-kan.');

            return self::SUCCESS;
        }

        foreach ($orders as $order) {
            $order->update(['status' => 'expired']);

            $this->line("Order #{$order->id} ({$order->service_name}) untuk user #{$order->user_id} → expired.");
        }

        $this->info("Selesai. {$orders->count()} layanan ditandai expired.");

        return self::SUCCESS;
    }
}
