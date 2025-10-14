<?php

namespace Tests\Unit\Services;

use App\Services\AbacatePayService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AbacatePayServiceTest extends TestCase
{

    public function test_create_pix_charge_returns_data_successfully(): void
    {
        $fakeApiResponse = [
            'payment_id' => 'pay_xyz123',
            'qr_code_data' => '00020126...',
            'status' => 'pending'
        ];

        Http::fake([
            config('services.abacatepay.url') . '/pixQrCode/create' =>
                Http::response($fakeApiResponse, 200)
        ]);

        $service = new AbacatePayService();
        $amountToCharge = 50.50;


        $result = $service->createPixCharge($amountToCharge, ['order_id' => '123']);


        $this->assertEquals($fakeApiResponse, $result);

        Http::assertSent(function ($request) use ($amountToCharge) {
            return $request->url() == config('services.abacatepay.url') . '/pixQrCode/create' &&
                $request['amount'] == $amountToCharge &&
                $request['metadata']['order_id'] == '123';
        });
    }
}