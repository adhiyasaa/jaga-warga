<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Report;
use App\Mail\ReportSubmitted;
use App\Models\User;

class ReportController extends Controller
{
    // ... (showStep1, storeStep1, showStep2 methods remain unchanged) ...

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

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi login Anda habis. Silakan login kembali untuk menyimpan laporan.');
        }

        $request->validate([
            'incident_type' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'incident_time' => 'required',
            'incident_location' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
            'is_anonymous' => 'required|string|in:yes,no',
        ]);

        $step1Data = Session::get('report_data');

        $evidencePath = null;
        if ($request->hasFile('evidence_file')) {
            try {
                $file = $request->file('evidence_file');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

                $evidencePath = Storage::disk('supabase')->putFileAs('', $file, $filename);

                if (!$evidencePath) {
                    throw new \Exception('File upload failed or returned empty path.');
                }

            } catch (\Exception $e) {
                Log::error("File Upload Error (Supabase): " . $e->getMessage());
                return back()->withInput()->withErrors(['evidence_file' => 'Gagal mengupload file. Pastikan konfigurasi Supabase dan koneksi internet Anda benar.']);
            }
        }

        try {
            $report = Report::create([
                'user_id' => Auth::id(),
                'status' => 'Terkirim',
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'place_of_birth' => $step1Data['place_of_birth'],
                'date_of_birth' => $step1Data['date_of_birth'],
                'home_address' => $step1Data['home_address'],
                'email' => $step1Data['email'],
                'phone_number' => $step1Data['phone_number'],
                'incident_type' => $request->input('incident_type'),
                'incident_date' => $request->input('incident_date'),
                'incident_time' => $request->input('incident_time'),
                'incident_location' => $request->input('incident_location'),
                'description' => $request->input('description'),
                'is_anonymous' => $request->input('is_anonymous'),

                'evidence_file_path' => $evidencePath,
            ]);

            Log::info("Laporan baru berhasil dibuat ID: " . $report->id);
        } catch (\Exception $e) {
            if ($evidencePath) {
                Storage::disk('supabase')->delete($evidencePath);
            }
            Log::error("Database Save Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['db_error' => 'Terjadi kesalahan saat menyimpan data ke database.']);
        }

        // ... (Logika Email & Session tetap sama) ...
        try {
            $dummyPoliceEmail = config('mail.mail_report_to_address');
            if ($dummyPoliceEmail) {
                $emailData = array_merge($step1Data, $request->all(), ['evidence_file_path' => $evidencePath]);
                Mail::to($dummyPoliceEmail)->send(new ReportSubmitted($emailData));
            }
        } catch (\Exception $e) {
            Log::error("Email Sending Error: " . $e->getMessage());
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
