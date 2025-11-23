<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Mail\ReportSubmitted;

class ReportController extends Controller
{
    // ... (fungsi showStep1, storeStep1, showStep2 tidak berubah) ...
    public function showStep1()
    {
        $reportData = Session::get('report_data', []);
        return view('report-step1', compact('reportData'));
    }

    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'home_address' => 'required|string|min:10',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:10|max:15',
        ]);

        Session::put('report_data', $validatedData);

        return redirect()->route('report.step2.show');
    }

    public function showStep2()
    {
        if (!Session::has('report_data')) {
            return redirect()->route('report.step1.show')->withErrors('Silakan isi data diri Anda terlebih dahulu.');
        }
        $reportData = Session::get('report_data', []);
        return view('report-step2', compact('reportData'));
    }


    public function storeStep2(Request $request)
    {
        if (!Session::has('report_data')) {
            return redirect()->route('report.step1.show')->withErrors('Sesi Anda telah berakhir. Silakan isi data diri Anda lagi.');
        }

        $validatedData = $request->validate([
            'incident_type' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'incident_location' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'is_anonymous' => 'required|string|in:yes,no',
        ]);

        $evidenceStoragePath = null;
        $step1Data = Session::get('report_data');
        $fullReportData = array_merge($step1Data, $validatedData);

        try {
            if ($request->hasFile('evidence_file')) {
                
                // --- INI PERBAIKANNYA ---
                // Ubah 'reports' menjadi '/' agar file disimpan di root bucket
                // (Bucket 'reports' Anda sudah diatur di .env)
                $evidenceStoragePath = $request->file('evidence_file')->store('/');
                // --- AKHIR PERBAIKAN ---

                if (!$evidenceStoragePath) {
                    throw new \Exception('File upload failed silently. Storage::putFile returned null or false.');
                }
            }

            $newReport = Report::create([
                //... (data lainnya)
                'user_id' => Auth::check() ? Auth::id() : null,
                'first_name' => $fullReportData['first_name'],
                'last_name' => $fullReportData['last_name'],
                'place_of_birth' => $fullReportData['place_of_birth'],
                'date_of_birth' => $fullReportData['date_of_birth'],
                'home_address' => $fullReportData['home_address'],
                'email' => $fullReportData['email'],
                'phone_number' => $fullReportData['phone_number'],
                'incident_type' => $fullReportData['incident_type'],
                'incident_date' => $fullReportData['incident_date'],
                'incident_time' => $fullReportData['incident_time'],
                'incident_location' => $fullReportData['incident_location'], 
                'evidence_file_path' => $evidenceStoragePath,
                'is_anonymous' => $fullReportData['is_anonymous'],
                'description' => $fullReportData['description'],
                'status' => 'Terkirim',
            ]);

        } catch (\Exception $e) {
            if ($evidenceStoragePath) {
                Storage::delete($evidenceStoragePath);
            }
            return back()->withInput()->withErrors(['db_error' => 'Gagal terhubung ke storage: ' . $e->getMessage()]);
        }
        
        $fullReportData['evidence_file_path'] = $evidenceStoragePath;
        $dummyPoliceEmail = config('mail.mail_report_to_address');
        
        try {
            Mail::to($dummyPoliceEmail)->send(new ReportSubmitted($fullReportData));
        } catch (\Exception $e) {
            // Email gagal
        }
        
        Session::forget('report_data');

        return redirect()->route('report.success');
    }

    public function listAllReports()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();
        return redirect(route('home'))->with('status', 'Halaman reports index belum dibuat.');
    }
}