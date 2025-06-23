<?php

namespace App\Http\Controllers\Comprof;

use App\Http\Controllers\Controller;
use App\Models\Comprof\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'desc')->get();
        return view('comprof.slider.index', compact('sliders'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        try {
            $path = $request->file('image')->store('sliders', 'public');
            
            $slider = Slider::create([
                'title' => $validated['title'],
                'link' => $validated['link'],
                'image' => $path,
                'status' => $validated['status']
            ]);

            return response()->json([
                'message' => 'Slider berhasil ditambahkan',
                'data' => $slider
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating slider: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Slider $slider): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|boolean',
        ]);

        // Handle file upload if new image is provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            
            $path = $request->file('image')->store('sliders', 'public');
            $validated['image'] = $path;
        } else {
            // Keep the existing image if no new image is uploaded
            $validated['image'] = $slider->image;
        }

        $slider->update($validated);

        return response()->json([
            'message' => 'Slider berhasil diperbarui',
            'data' => $slider
        ]);
    }

    public function destroy(Slider $slider): JsonResponse
    {
        // Delete associated image
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return response()->json([
            'message' => 'Slider berhasil dihapus'
        ]);
    }
}