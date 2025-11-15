<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\View\View;

class InformationController extends Controller
{
    /**
     * Menampilkan halaman informasi.
     */
    public function index(): View
    {
        $informations = Information::orderBy('created_at', 'desc')->get();
        return view('information', [
            'informations' => $informations
        ]);
    }
}
