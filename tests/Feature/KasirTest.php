<?php

namespace Tests\Feature;

use Tests\TestCase;

class KasirTest extends TestCase
{
    public function test_kasir_page_renders_the_pos_interface(): void
    {
        $response = $this->get('/kasir');

        $response->assertOk()
            ->assertSee('TOKO RETAIL MAKMUR')
            ->assertSee('BAYAR & CETAK', false)
            ->assertSee('js/cashier.js');
    }
}
