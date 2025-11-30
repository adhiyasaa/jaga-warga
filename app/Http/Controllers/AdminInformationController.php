<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Information; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminInformationController extends Controller
{
    public function index()
    {
        $informations = Information::latest()->get();
        return view('admin.information', compact('informations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'event'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'nullable|url',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $path = Storage::disk('supabase_info')->putFileAs('', $file, $filename);
            
            $fullUrl = Storage::disk('supabase_info')->url($path);
            $validated['image_path'] = $fullUrl;
        }

        Information::create($validated);

        return redirect()->route('admin.information')
                         ->with('success', 'Information added successfully.');
    }

    public function update(Request $request, Information $information)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'event'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'url'         => 'nullable|url',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            if ($information->image_path) {
                $oldFilename = basename($information->image_path); 
                
                if (Storage::disk('supabase_info')->exists($oldFilename)) {
                    Storage::disk('supabase_info')->delete($oldFilename);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $path = Storage::disk('supabase_info')->putFileAs('', $file, $filename);
            
            $validated['image_path'] = Storage::disk('supabase_info')->url($path);
        }

        $information->update($validated);

        return redirect()->route('admin.information')
                         ->with('success', 'Information updated successfully.');
    }

    public function destroy(Information $information)
    {
        if ($information->image_path) {
            $filename = basename($information->image_path);
            
            if (Storage::disk('supabase_info')->exists($filename)) {
                Storage::disk('supabase_info')->delete($filename);
            }
        }

        $information->delete();

        return redirect()->route('admin.information')
                         ->with('success', 'Information deleted successfully.');
    }
}