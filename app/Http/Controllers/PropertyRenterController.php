<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyRenter;

class PropertyRenterController extends Controller
{
    public function create(Request $request, $propertyID)
    {
        $request->validate([
            'tipe_harga_sewa' => 'required|string',
            'periode_sewa' => 'required|string',
            'nama_vendor' => 'required|string',
            'no_hp_vendor' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $request->merge(['property_id' => $propertyID]);

        $propertyRenter = PropertyRenter::create($request->all());

        return response()->json([
            'message' => 'Property renter created successfully',
            'data' => $propertyRenter,
        ]);
    }

    public function list($propertyID)
    {
        $propertyRenter = PropertyRenter::where('property_id', $propertyID)->first();

        if (!$propertyRenter) {
            return response()->json([
                'message' => 'Property renter not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Property renter found',
            'data' => $propertyRenter,
        ]);
    }
}
