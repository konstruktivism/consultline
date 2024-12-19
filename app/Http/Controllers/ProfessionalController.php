<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = Professional::whereHas('availabilities', function ($query) {
            $query->where('day_of_week', Carbon::now()->dayOfWeek);
        })->get();

        return view('welcome', ['professionals' => $professionals]);
    }
}
