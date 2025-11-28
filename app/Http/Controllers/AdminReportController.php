<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminReportController extends Controller
{
    /**
     * Menampilkan daftar laporan.
     */
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        
        return view('admin.report', compact('reports'));
    }

    /**
     * Mengubah status laporan menjadi 'Solved'.
     * Diakses melalui tombol "Solve" di tabel.
     */
    public function solve(Report $report)
    {
        $report->update([
            'status' => 'Solved'
        ]);

        return redirect()->route('admin.report')
                         ->with('success', 'Report has been marked as solved.');
    }

    /**
     * Menghapus laporan beserta file buktinya.
     */
    public function destroy(Report $report)
    {
        if ($report->evidence_file_path) {
            if (Storage::disk('supabase')->exists($report->evidence_file_path)) {
                Storage::disk('supabase')->delete($report->evidence_file_path);
            }
        }

        $report->delete();

        return redirect()->route('admin.report')
                         ->with('success', 'Report deleted successfully.');
    }
}