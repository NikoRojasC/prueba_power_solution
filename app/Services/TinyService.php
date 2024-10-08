<?php

namespace app\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use App\Services\BracketBalanceService;
use Illuminate\Support\Facades\Log;

class TinyService
{

    protected $apiToken;
    protected $bracketBalanceService;

    public function __construct(BracketBalanceService $bracketBalanceService)
    {
        $this->apiToken = env('TINY_API');
        $this->bracketBalanceService = $bracketBalanceService;
    }

    public function shortUrl($url)
    {

        if (!$this->bracketBalanceService->isBalanced('[]({}')) {

            throw new \Exception('URL inválida.');
        }
        $apiUrl = 'https://tinyurl.ph/api/url/add';
        $data = [
            'url' => $url
        ];

        $headers = [
            'Authorization: Bearer ' . $this->apiToken,
            'Content-Type: application/json'
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (!$response) {
            throw new Exception('Problema al conectarse a la API' . curl_error($ch));
        }
        curl_close($ch);


        $resData = json_decode($response, true);




        return $resData;
    }
}
