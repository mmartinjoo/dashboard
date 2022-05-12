<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetDashboardRequest;
use App\ViewModels\GetDashboardViewModel;

class GetDashboardController extends Controller
{
    public function __invoke(GetDashboardRequest $request)
    {
        return view('dashboard', [
            'model' => (new GetDashboardViewModel($request->products()))->toArray(),
        ]);
    }
}
