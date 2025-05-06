<?php

namespace App\Http\Controllers\Comprof;

use App\Http\Controllers\Controller;
use App\Models\Comprof\Datastaf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataStafController extends Controller
{
    public function index()
    {
        $staffs = Datastaf::orderBy('name')->get();
        return view('comprof.datastaf.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
            'education' => 'required|string',
            'status' => 'required|boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('staff-profiles', 'public');
        }

        Datastaf::create($validated);

        return redirect()->route('comprof.datastaf.index')
            ->with('success', 'Data staf berhasil ditambahkan.');
    }

    public function update(Request $request, Datastaf $datastaf)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
            'education' => 'required|string',
            'status' => 'required|boolean'
        ]);

        // Handle file upload if new image is provided
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($datastaf->profile_image) {
                Storage::disk('public')->delete($datastaf->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('staff-profiles', 'public');
        } else {
            // Keep the existing image if no new image is uploaded
            $validated['profile_image'] = $datastaf->profile_image;
        }

        $datastaf->update($validated);

        return redirect()->route('comprof.datastaf.index')
            ->with('success', 'Data staf berhasil diperbarui.');
    }

    public function destroy(Datastaf $datastaf)
    {
        // Delete associated image
        if ($datastaf->profile_image) {
            Storage::disk('public')->delete($datastaf->profile_image);
        }

        $datastaf->delete();

        return redirect()->route('comprof.datastaf.index')
            ->with('success', 'Data staf berhasil dihapus.');
    }
}