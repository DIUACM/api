<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PipraPay
{
    protected string $api_key;

    protected string $base_url;

    protected string $currency;

    public function __construct(string $api_key, string $base_url, string $currency = 'BDT')
    {
        $this->api_key = $api_key;
        $this->base_url = rtrim($base_url, '/');
        $this->currency = $currency;
    }

    public function createCharge(array $data): array
    {
        $data['currency'] = $this->currency;

        return $this->post('/api/create-charge', $data);
    }

    public function verifyPayment(string $pp_id): array
    {
        return $this->post('/api/verify-payments', ['pp_id' => $pp_id]);
    }

    public function handleWebhook(string $expected_api_key): array
    {
        $received_key = request()->header('mh-piprapay-api-key');

        if ($received_key !== $expected_api_key) {
            return ['status' => false, 'message' => 'Unauthorized'];
        }

        return ['status' => true, 'data' => request()->all()];
    }

    protected function post(string $endpoint, array $data): array
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'mh-piprapay-api-key' => $this->api_key,
        ])->post($this->base_url.$endpoint, $data);

        if ($response->successful()) {
            return $response->json();
        }

        return ['status' => false, 'error' => $response->body()];
    }
}
