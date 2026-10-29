<?php

namespace Tests\Unit;

use App\Models\ProductOrder;
use PHPUnit\Framework\TestCase;

/**
 * Unit test untuk logika status label ProductOrder.
 */
class ProductOrderStatusTest extends TestCase
{
    /** @dataProvider statusProvider */
    public function test_status_label_benar(string $status, string $expected): void
    {
        $order = new ProductOrder();
        $order->status = $status;

        $this->assertEquals($expected, $order->status_label);
    }

    public function test_status_tidak_dikenal_kembalikan_status_mentah(): void
    {
        $order = new ProductOrder();
        $order->status = 'unknown_status';

        $this->assertEquals('unknown_status', $order->status_label);
    }

    public static function statusProvider(): array
    {
        return [
            'pending'    => ['pending',    'Menunggu Konfirmasi'],
            'confirmed'  => ['confirmed',  'Dikonfirmasi'],
            'shipped'    => ['shipped',    'Dikirim'],
            'done'       => ['done',       'Selesai'],
            'cancelled'  => ['cancelled',  'Dibatalkan'],
        ];
    }
}
