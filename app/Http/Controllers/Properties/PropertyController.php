<?php

namespace App\Http\Controllers\Properties;

use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AgentProperty;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'status' => 'required|string',
            'tipe_properti' => 'required|string',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer',
            'area' => 'required|string',
            'provinsi_id' => 'integer',
            'kota_id' => 'integer',
            'kecamatan_id' => 'integer',
            'luas_tanah' => 'integer',
            'luas_bangunan' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
            'kamar_tidur_pembantu' => 'integer',
            'kamar_mandi_pembantu' => 'integer',
            'listrik' => 'integer',
            'air' => 'string',
            'sertifikat' => 'string',
            'posisi_rumah' => 'string',
            'garasi_dan_carport' => 'integer',
            'kondisi_bangunan' => 'string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }
        $request->merge([
            'agent_id' => $request->user()->id
        ]);

       
        try {
            DB::beginTransaction();
            $property = Property::create($request->except('images'));
            if($request->hasFile('images') && $property){
                foreach ($request->file('images') as $key => $value) {
                    $image_name[] = [
                        'property_id' => $property->id,
                        'image_url' => Storage::disk('public')->put('images', $value)
                    ];
                }
                PropertyImage::insert($image_name);
            }
            AgentProperty::create([
                'agent_id' => $request->user()->id,
                'property_id' => $property->id
            ]);
            DB::commit();
            return response()->json([
                'message' => 'data created',
                'status' => 'created'
            ], 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => "error when creating data",
                'status' => 'error'
            ], 400);
        }
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'judul' => 'string',
            'status' => 'string',
            'tipe_properti' => 'string',
            'deskripsi' => 'string',
            'harga' => 'integer',
            'area' => 'string',
            'provinsi_id' => 'integer',
            'kota_id' => 'integer',
            'kecamatan_id' => 'integer',
            'luas_tanah' => 'integer',
            'luas_bangunan' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
            'kamar_tidur_pembantu' => 'integer',
            'kamar_mandi_pembantu' => 'integer',
            'listrik' => 'integer',
            'air' => 'string',
            'sertifikat' => 'string',
            'posisi_rumah' => 'string',
            'garasi_dan_carport' => 'integer',
            'kondisi_bangunan' => 'string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }

        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where('property_id', $id)->get();
            $is_in_array = in_array($request->user()->id, $agent_property->pluck('agent_id')->toArray());
            if($is_in_array ||  $request->user()->hasRole(['admin','owner'])){
                $property->update($request->except('images'));
                if($request->hasFile('images')){
                    $data_image = PropertyImage::where('property_id', $id)->get();
                    foreach ($data_image as $key => $value) {
                        Storage::disk('public')->delete($value->image_url);
                    }
                    $data_image->each->delete();
                    foreach ($request->file('images') as $key => $value) {
                        $image_name[] = [
                            'property_id' => $property->id,
                            'image_url' => Storage::disk('public')->put('images', $value)
                        ];
                    }
                    PropertyImage::insert($image_name);
                }
                DB::commit();
                return response()->json([
                    'message' => 'data updated',
                    'status' => 'updated'
                ], 200);
            }
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'error when updating data',
                'status' => 'error'
            ], 400);
        }
    }

    public function delete (Request $request, $id){
        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where('property_id', $id)->get();
            $is_in_array = in_array($request->user()->id, $agent_property->pluck('agent_id')->toArray());
            if( $is_in_array || $request->user()->hasRole(['admin','owner'])){
                $data_image = PropertyImage::where('property_id', $id)->get();
                foreach ($data_image as $key => $value) {
                    Storage::disk('public')->delete($value->image_url);
                }
                $property->delete();
                DB::commit();
                return response()->json([
                    'message' => 'data deleted',
                    'status' => 'deleted'
                ], 200);
            }
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'message' => 'error when deleting data',
                'status' => 'error'
            ], 400);
        }
    }

    public function detail(Request $request, $id){
        try {
            $property = Property::find($id);
            if($property){
                return response()->json([
                    'message' => 'data found',
                    'status' => 'found',
                    'data' => $property
                ], 200);
            }
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error when getting data',
                'status' => 'error'
            ], 400);
        }
    }

    public function getPaginate(){
        try {
            $property = Property::with('images', 'creator')->paginate(10, ['id','judul','tipe_properti','harga','luas_tanah','kamar_mandi','kamar_tidur','agent_id']);
            if($property){
                return response()->json([
                    'message' => 'data found',
                    'status' => 'found',
                    'data' => $property
                ], 200);
            }
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error when getting data',
                'status' => 'error'
            ], 400);
        }
    }

    public function getPaginateByAgent(Request $request){
        try {
            $property = AgentProperty::where('agent_id', $request->user()->id)->with('data:id,judul,tipe_properti,harga,luas_tanah,kamar_mandi,kamar_tidur,agent_id', 'data.creator')->paginate(10);
            if($property){
                return response()->json([
                    'message' => 'data found',
                    'status' => 'found',
                    'data' => $property
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error when getting data',
                'status' => 'error'
            ], 400);
        }
    }
}
