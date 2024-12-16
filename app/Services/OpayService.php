<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Http;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\PublicKeyLoader;

class OPayService
{
    private $publicKey;
    private $privateKey;
    private $merchantId;
    private $url;
    private $clientAuthKey;
    private $version;

    // OPay public key and your private key from config
    private $opayPublicKey;
    private $opayPrivateKey;

    public function __construct()
    {
        $this->merchantId = config('opay.merchant_id');
        $this->publicKey = config('opay.public_key'); // Your OPay public key
        $this->privateKey = config('opay.private_key'); // Your private RSA key
        $this->opayPublicKey = config('opay.opay_public_key'); // OPay's public key for verification
        $this->opayPrivateKey = config('opay.opay_private_key'); // OPay's private key (if required)
        $this->clientAuthKey = config('opay.client_auth_key');
        $this->version = 'V1.0.1';
        $this->url = 'https://payapi.opayweb.com/api/v2/third/depositcode/generateStaticDepositCode';
    }

    // Step 1: Generate timestamp (milliseconds)
    private function generateTimestamp()
    {
        return (string) round(microtime(true) * 1000);
    }

    // Step 2: Encrypt paramContent with OPay's public key
    private function encryptParamContent(array $data)
    {
        // Convert the data to JSON format
        $dataJson = json_encode($data, JSON_UNESCAPED_SLASHES);

        // Encrypt with OPay's public key
        $rsa = PublicKeyLoader::load($this->opayPublicKey);
        $encryptedData = $rsa->encrypt($dataJson);

        // Return base64 encoded encrypted data
        return base64_encode($encryptedData);
    }

    // Step 3: Generate sign using your private key and timestamp + encrypted paramContent
    private function generateSign(string $timestamp, string $paramContent)
    {
        // Concatenate timestamp and paramContent for signing
        $dataToSign = $timestamp . $paramContent;

        // Sign with your private key
        $rsa = RSA::load($this->privateKey);
        $signature = $rsa->sign($dataToSign);

        // Return base64 encoded signature
        return base64_encode($signature);
    }

    // Step 4: Process the request to create a digital wallet
    public function createDigitalWallet(array $data)
    {
        try {
            // Generate the timestamp
            $timestamp = $this->generateTimestamp();

            // Step 1: Encrypt the data (paramContent)
            $paramContent = $this->encryptParamContent($data);

            // Step 2: Generate the signature
            $sign = $this->generateSign($timestamp, $paramContent);

            // Build the request body
            $requestBody = [
                'paramContent' => $paramContent,
                'sign' => $sign
            ];

            // Set the request headers
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->publicKey,
                'MerchantId' => $this->merchantId,
                'clientAuthKey' => $this->clientAuthKey,
                'version' => $this->version,
                'bodyFormat' => 'JSON',
                'timestamp' => $timestamp,
            ];

            // Make the POST request to OPay
            $response = Http::withHeaders($headers)->post($this->url, $requestBody);

            // Get the response body
            $responseBody = json_decode($response->getBody()->getContents(), true);

            // Check the response code and handle success or failure
            if ($responseBody['code'] === '00000') {
                return $responseBody['data'];
            }

            throw new \Exception($responseBody['message']);
        } catch (\Exception $e) {
            throw new \Exception('Error creating digital wallet: ' . $e->getMessage());
        }
    }

    // Step 5: Verify the response signature and decrypt the response data
    public function verifyResponse(array $responseData)
    {
        try {
            // Extract the signature and data from the response
            $sign = $responseData['sign'];
            $data = $responseData['data'];

            // Decrypt the data using your private key
            $rsa = RSA::load($this->privateKey);
            $decryptedData = $rsa->decrypt(base64_decode($data));

            // Verify the signature using OPay's public key
            $opayRsa = PublicKeyLoader::load($this->opayPublicKey);
            $isValidSignature = $opayRsa->verify($decryptedData, base64_decode($sign));

            if ($isValidSignature) {
                // Return the decrypted data
                return json_decode($decryptedData, true);
            }

            throw new \Exception('Invalid response signature');
        } catch (\Exception $e) {
            throw new \Exception('Error verifying response: ' . $e->getMessage());
        }
    }
}
