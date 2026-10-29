<?php

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Product;
use PHPUnit\Framework\TestCase;

/**
 * Unit test murni — tidak butuh database.
 * Tes logika perhitungan subtotal CartItem.
 */
class CartItemSubtotalTest extends TestCase
{
    public function test_subtotal_dihitung_dengan_benar(): void
    {
        // Buat mock Product sederhana
        $product = new Product();
        $product->price = 500000;

        $item = new CartItem();
        $item->qty = 3;
        $item->setRelation('product', $product);

        $this->assertEquals(1500000, $item->subtotal);
    }

    public function test_subtotal_qty_satu(): void
    {
        $product = new Product();
        $product->price = 250000;

        $item = new CartItem();
        $item->qty = 1;
        $item->setRelation('product', $product);

        $this->assertEquals(250000, $item->subtotal);
    }

    public function test_subtotal_harga_desimal(): void
    {
        $product = new Product();
        $product->price = '199999.50'; // dari DB bisa berupa string decimal

        $item = new CartItem();
        $item->qty = 2;
        $item->setRelation('product', $product);

        $this->assertEquals(399999.0, $item->subtotal);
    }
}
