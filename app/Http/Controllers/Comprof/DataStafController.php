<?php

namespace App\Http\Controllers\Comprof;

use App\Http\Controllers\Controller;
use App\Models\Comprof\Datastaf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class DataStafController extends Controller
{
    public function index()
    {
        $staffs = Datastaf::orderBy('name')->get();
        return view('comprof.datastaf.index', compact('staffs'));
    }

    public function store(Request $request): JsonResponse
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'jabatan' => 'required|string|max:255',
        'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'description' => 'required|string',
        'education' => 'required|string',
    ]);

    try {
        $path = $request->file('profile_image')->store('staff-profiles', 'public');
        
        $staff = Datastaf::create([
            'name' => $validated['name'],
            'jabatan' => $validated['jabatan'],
            'profile_image' => $path,
            'description' => $validated['description'],
            'education' => $validated['education'],
            'status' => true // Default status aktif
        ]);

        return response()->json([
            'message' => 'Data staf berhasil ditambahkan',
            'data' => $staff
        ], 201);
    } catch (\Exception $e) {
        Log::error('Error creating staff: ' . $e->getMessage());
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan data',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function update(Request $request, Datastaf $datastaf): JsonResponse
    {
        // PERBAIKAN: Hapus validasi status
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string',
            'education' => 'required|string',
            // 'status' => 'required|boolean' // DIHAPUS
        ]);

        // Handle file upload if new image is provided
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($datastaf->profile_image) {
                Storage::disk('public')->delete($datastaf->profile_image);
            }
            
            $path = $request->file('profile_image')->store('public/staff-profiles');
            $validated['profile_image'] = str_replace('public/', '', $path);
        } else {
            // Keep the existing image if no new image is uploaded
            $validated['profile_image'] = $datastaf->profile_image;
        }

        $datastaf->update($validated);

        return response()->json([
            'message' => 'Data staf berhasil diperbarui',
            'data' => $datastaf
        ]);
    }

    public function destroy(Datastaf $datastaf): JsonResponse
    {
        // Delete associated image
        if ($datastaf->profile_image) {
            Storage::disk('public')->delete($datastaf->profile_image);
        }

        $datastaf->delete();

        return response()->json([
            'message' => 'Data staf berhasil dihapus'
        ]);
    }
}