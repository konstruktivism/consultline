<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProfessionalController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.rinkel.com/v1/', // Base URI for Rinkel API
            'timeout'  => 5.0,
        ]);
    }

    public function index()
    {
        $professionals = Professional::whereHas('availabilities', function ($query) {
            $query->where('day_of_week', Carbon::now()->dayOfWeek);
        })->get();

        try {
            $response = $this->client->request('GET', 'numbers/' . config('app.rinkel_number_id'), [
                'headers' => [
                    'x-rinkel-api-key' => env('RINKEL_API'), // Use the correct header
                    'Accept'        => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return view('welcome', ['numbers' => $data, 'professionals' => $professionals]);
        } catch (\Exception $e) {
            return view('welcome', ['error' => $e->getMessage(), 'professionals' => $professionals]);
        }
    }
}
