<?php

namespace App\Http\Controllers;

use App\Services\OPayService;
use Illuminate\Http\Request;

class CashierCreateController extends Controller
{
    protected $opayService;

    public function __construct(OPayService $opayService)
    {
        $this->opayService = $opayService;
    }

    public function createOrder(Request $request)
    {
        $data = [
            'headMerchantId' => '256622092286390',
            'merchantId' => '256622092286391',
            'outOrderNo' => '2334345345348734',
            'amount' => '2200.00',
            'currency' => 'NGN',
            'orderExpireTime' => 300,
            'productInfo' => json_encode([
                'filmName' => 'Avatar:The Way of Water',
                'filmTitle' => 'ticket title',
                'filmTicketNum' => 'film ticker number',
                'seatNum' => 'Seat number(multiple seats, concatenate)',
                'filmTicketAmount' => '100',
                'filmFeeAmount' => '5',
                'filmDate' => 'movie date 2024-05-12',
                'filmTime' => 'movie showtime, 19:00',
            ]),
            'isSplit' => 'N',
            'remark' => 'test film app',
            'sceneEnum' => 'COLLECTION_SDK',
            'subSceneEnum' => 'LOGISTIC',
            'sn' => '9210264890',
        ];

        try {
            $response = $this->opayService->createOrder($data);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function createWallet(Request $request)
    {
        $data = [
            'opayMerchantId' => config('opay.merchant_id'),
            'refId' => 'refer1200000850',
            'name' => 'abc',
            'email' => 'opay@gmail.com',
            'phone' => '2341231231231',
            'accountType' => 'Merchant',
            'sendPassWordFlag' => 'N',
        ];

        try {
            $walletData = $this->opayService->createDigitalWallet($data);
            return response()->json(['success' => true, 'data' => $walletData]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
        }
    }

    
}
