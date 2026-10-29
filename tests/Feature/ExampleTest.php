<?php

namespace Tests\Feature;

use App\Models\PaymentSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_dapat_diakses(): void
    {
        // Pastikan PaymentSetting ada sebelum hit welcome page
        PaymentSetting::current();

        $response = $this->get('/');

        $this->assertNotEquals(500, $response->status(),
            "Welcome page error 500. Cek apakah semua migration sudah jalan."
        );
    }
}
