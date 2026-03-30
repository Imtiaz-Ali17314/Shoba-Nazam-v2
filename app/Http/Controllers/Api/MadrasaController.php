<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Madrasa;
use Illuminate\Support\Facades\Storage;

class MadrasaController extends Controller
{
    /**
     * Get madrasa settings
     */
    public function show(Request $request)
    {
        $madrasa = Madrasa::findOrFail($request->user()->madrasa_id);
        
        $data = $madrasa->toArray();
        $data['logo_url'] = $madrasa->logo ? asset('storage/' . $madrasa->logo) : null;
        
        return response()->json($data);
    }

    /**
     * Update madrasa settings including logo
     */
    public function update(Request $request)
    {
        $madrasa = Madrasa::findOrFail($request->user()->madrasa_id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'academic_year' => 'nullable|string|max:50',
            'primary_color' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($madrasa->logo && Storage::disk('public')->exists($madrasa->logo)) {
                Storage::disk('public')->delete($madrasa->logo);
            }
            
            $path = $request->file('logo')->store('logos', 'public');
            $validated['logo'] = $path;
        }

        $madrasa->update($validated);

        $data = $madrasa->toArray();
        $data['logo_url'] = $madrasa->logo ? asset('storage/' . $madrasa->logo) : null;

        return response()->json([
            'message' => 'Settings updated successfully',
            'data' => $data
        ]);
    }
}
