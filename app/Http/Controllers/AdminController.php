<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $activityCount = 0;
        $reportCount = 0;
        $consultationCount = 0;
        $reports = [];
        $consultations = [];

        return view('admin.dashboard', compact(
            'activityCount',
            'reportCount',
            'consultationCount',
            'reports',
            'consultations'
        ));
    }
}
