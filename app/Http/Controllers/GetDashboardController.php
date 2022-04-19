<?php

namespace App\Http\Controllers;

use App\ViewModels\GetDashboardViewModel;

class GetDashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboard', [
            'model' => (new GetDashboardViewModel())->toArray(),
        ]);
    }
}
