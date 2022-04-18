<?php

namespace App\Http\Controllers;

use App\Services\Gumroad\GumroadService;
use App\ViewModels\GetDashboardViewModel;

class GetDashboardController extends Controller
{
    public function __invoke(GumroadService $gumroad)
    {
        return view('dashboard', [
            'model' => (new GetDashboardViewModel($gumroad))->toArray(),
        ]);
    }
}
