<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use Illuminate\Http\Request;

class AdminConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with(['user', 'psychologist'])
            ->latest()
            ->paginate(10);

        return view('admin.consultation', compact('consultations'));
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->back()->with('success', 'Data konsultasi berhasil dihapus.');
    }
}