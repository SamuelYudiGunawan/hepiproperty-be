<?php

namespace App\Http\Controllers\Properties;

use Illuminate\Http\Request;
use App\Models\PropertyUnggulan;
use App\Http\Controllers\Controller;

class PropertyUnggulanController extends Controller
{
    public function addToUnggulan(Request $request, $id){
        PropertyUnggulan::create([
            'property_id' => $id
        ]);
 
        return response()->json([
            'message' => 'data added to unggulan',
            'status' => 'added'
        ], 201);
     }
 
     public function removeFromUnggulan(Request $request, $id){
         PropertyUnggulan::destroy($id);
 
         return response()->json([
             'message' => 'data removed from unggulan',
             'status' => 'removed'
         ], 200);
     }
 
     public function getUnggulan(){
         $property = PropertyUnggulan::with('data:id,slug,judul,tipe_properti,harga,luas_tanah,kamar_mandi,kamar_tidur,agent_id,created_at,area', 'data.creator')->paginate(6);
         return response()->json([
             'message' => 'data found',
             'status' => 'found',
             'data' => $property
         ], 200);
     }

     public function getHighlight(){
        $property = PropertyUnggulan::where('highlight', 1)->with('data:id,slug,judul,tipe_properti,harga,luas_tanah,kamar_mandi,kamar_tidur,agent_id,created_at,area', 'data.creator')->get();
        return response()->json([
            'message' => 'data found',
            'status' => 'found',
            'data' => $property
        ], 200);
    }

    public function setHighlight(Request $request, $id){
        $property = PropertyUnggulan::find($id);
        $property->highlight = 1;
        $property->save();
        return response()->json([
            'message' => 'data highlighted',
            'status' => 'highlighted'
        ], 200);
    }

    public function removeHighlight(Request $request, $id){
        $property = PropertyUnggulan::find($id);
        $property->highlight = 0;
        $property->save();
        return response()->json([
            'message' => 'data removed from highlight',
            'status' => 'removed'
        ], 200);
    }
}
