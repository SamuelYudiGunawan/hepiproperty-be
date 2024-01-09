<?php

namespace App\Http\Controllers\Area;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getProvinsi(){
        $area = Provinsi::all();
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function getKota($provinsi_id){
        $area = Kota::where('provinsi_id', $provinsi_id)->get();
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function getKecamatan($kota_id){
        $area = Kecamatan::where('kota_id', $kota_id)->get();
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function provinsiDetail($id){
        $area = Provinsi::find($id);
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function kotaDetail($id){
        $area = Kota::with('provinsi')->find($id);
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function kecamatanDetail($id){
        $area = Kecamatan::with('kota', 'kota.provinsi')->find($id);
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }

    public function getSemarang(){
        $area = Kecamatan::whereIn('kota_id', [209, 220])->get();
        if (!$area) {
            return response()->json([
                'message' => 'data not found',
                'data' => null
            ], 400);
        }
        return response()->json([
            'message' => 'success',
            'data' => $area
        ], 200);
    }
}
