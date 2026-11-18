<?php

namespace Tests\Feature;

use Tests\TestCase;

class ReceiptTest extends TestCase
{
    public function test_receipt_opens_as_a_pdf_without_a_physical_printer(): void
    {
        $response = $this->get(route('print.receipt'));

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertHeader('Content-Disposition', 'inline; filename=struk-pembayaran.pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
    }
}
