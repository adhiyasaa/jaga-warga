<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report; 
use App\Models\Consultation; 
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today();
        $activityCount = User::whereDate('updated_at', $today)->count();
        $reportCount = Report::whereDate('created_at', $today)->count();
        $consultationCount = Consultation::whereDate('created_at', $today)->count();
        $reports = Report::with('user')
                         ->orderBy('created_at', 'desc')
                         ->take(5)
                         ->get();

        $consultations = Consultation::with('user', 'psychologist')
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)
                                     ->get();


        return view('admin.dashboard', compact(
            'activityCount',
            'reportCount',
            'consultationCount',
            'reports',
            'consultations'
        ));
    }
}