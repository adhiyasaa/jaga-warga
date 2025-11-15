<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    public function index()
    {
        // Ambil semua user
        $roles = User::all();

        return view('admin.role', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:User,Psychologist,SuperAdmin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.role')->with('success', 'Role created successfully!');
    }

    public function show($id)
    {
        $role = User::findOrFail($id);
        return view('components.admin.role-modal-view', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $role->id,
            'role' => 'required|in:User,Psychologist,SuperAdmin',
        ]);

        $role->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.role')->with('success', 'Role updated!');
    }

    public function destroy($id)
    {
        $role = User::findOrFail($id);
        $role->delete();

        return redirect()->route('admin.role')->with('success', 'Role deleted!');
    }
}
