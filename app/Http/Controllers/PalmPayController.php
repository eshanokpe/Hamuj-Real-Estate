<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PalmPayController extends Controller
{
    public function createVirtualAccount()
    {
        $url = 'https://open-gw-daily.palmpay-inc.com/api/v2/virtual/account/label/create';
        $headers = [
            'Authorization' => 'Bearer L231127063379321376521',
            'countryCode' => 'NG',
            'Signature' => 'Xgp7oFDxe5Jvy859hDxvlFo2+Hc4VtZrMge+b09XLnwngPc7l2RinScXK4aADDMcreZtN5thCsj/qfM6rXzHBPF5lrUvAPN8TB+rc2wTacqNVLDElEusYjAEDVHCv9CeMsmTgsERMQgHpRwUkOLqUEcE7JAsX/MnHdFsv+nQdtqvc5wn0O7nCq/o2MhUiNhvNIw7UFfjy9p5Pz+JM8yV92Tno1QoWv0w01pWZHR15LoSauRCzdEN2K+ctbHrKF+He+xxHL0kdunI1yqj7hnfZ5qblEckR8DhqowAFNSu/Yp7TaAFbBBM4yGJTTEB4Hg7uocsWtd3zwYa2nU0lLetJA==',
            'content-type' => 'application/json;charset=UTF-8',
        ];

        $data = [
            "requestTime" => now()->timestamp * 1000,
            "identityType" => "company",
            "licenseNumber" => "dasd141234114123",
            "virtualAccountName" => "PPTV2",
            "version" => "V2.0",
            "customerName" => "palmpayTester",
            "email" => "2222@palmpay.com",
            "nonceStr" => "8GagBq4oGahVZAD8PQgLFJdhGQxoS1gy",
        ];

        $response = Http::withHeaders($headers)->post($url, $data);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body(),
            ], $response->status());
        }
    }
}
