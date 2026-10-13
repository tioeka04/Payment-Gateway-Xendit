<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XenditService
{
    private function client()
    {
        // Xendit pakai Basic Auth: secret key sebagai username, password kosong.
        return Http::withBasicAuth(config('services.xendit.secret_key'), '')
            ->baseUrl(config('services.xendit.base_url'))
            ->acceptJson();
    }

    public function createInvoice(array $data): array
    {
        return $this->client()->post('/v2/invoices', $data)->throw()->json();
    }

    public function getBalance(): array
    {
        return $this->client()->get('/balance')->throw()->json();
    }
}
