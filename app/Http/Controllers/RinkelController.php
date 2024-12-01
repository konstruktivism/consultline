<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class RinkelController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.rinkel.com/', // Base URI for Rinkel API
            'timeout'  => 5.0,
        ]);
    }

    public function listAllNumbers()
    {
        try {
            $response = $this->client->request('GET', 'numbers', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('RINKEL_API_TOKEN'),
                    'Accept'        => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSomeData()
    {
        try {
            $response = $this->client->request('GET', 'your-endpoint', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('app.rinkel_api'),
                    'Accept'        => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function postSomeData(Request $request)
    {
        try {
            $response = $this->client->request('POST', 'your-endpoint', [
                'headers' => [
                    'Authorization' => 'Bearer ' . config('app.rinkel_api'),
                    'Accept'        => 'application/json',
                ],
                'json' => $request->all(),
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
