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
            'title' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('information_images', 'public');
            $validated['image_path'] = $imagePath;
        }

        Information::create($validated);

        return redirect()->route('admin.information')
                         ->with('success', 'Information added successfully.');
    }

    public function update(Request $request, Information $information)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'event' => 'required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            if ($information->image_path) {
                Storage::disk('public')->delete($information->image_path);
            }
            $imagePath = $request->file('image')->store('information_images', 'public');
            $validated['image_path'] = $imagePath;
        }

        $information->update($validated);


        return redirect()->route('admin.information')
                         ->with('success', 'Information updated successfully.');
    }

    public function destroy(Information $information)
    {
        if ($information->image_path) {
            Storage::disk('public')->delete($information->image_path);
        }

        $information->delete();


        return redirect()->route('admin.information')
                         ->with('success', 'Information deleted successfully.');
    }
}