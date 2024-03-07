<?php

namespace App\Http\Controllers\Properties;

use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AgentProperty;
use App\Models\PropertyUnggulan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Jorenvh\Share\Share;

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
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }
        $request->merge([
            'agent_id' => $request->user()->id
        ]);

        $max_slug = Property::where('judul', $request->judul)->count();
        $slug = Str::slug($request->judul . "-" . $max_slug, '-');

        $request->merge([
            'slug' => $slug
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
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }

        if(Property::find($id)){
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        }
        
        if ($request->judul && $request->judul != Property::find($id)->judul) {
            $max_slug = Property::where('judul', $request->judul)->count();
            $slug = Str::slug($request->judul . "-" . $max_slug, '-');
            $request->merge([
                'slug' => $slug
            ]);
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

    public function updateWithImageID(Request $request, $id) {
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_id' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }
        
        if(!Property::find($id)){
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 404);
        }
        
        if ($request->judul && $request->judul != Property::find($id)->judul) {
            $max_slug = Property::where('judul', $request->judul)->count();
            $slug = Str::slug($request->judul . "-" . $max_slug, '-');
            $request->merge([
                'slug' => $slug
            ]);
        }
        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where('property_id', $id)->get();
            $is_in_array = in_array($request->user()->id, $agent_property->pluck('agent_id')->toArray());
            if($is_in_array ||  $request->user()->hasRole(['admin','owner'])){
                $property->update($request->except('images'));
                if($request->image_id){
                    $data_image = PropertyImage::whereIn('id', $request->image_id)->get();
                    foreach ($data_image as $key => $value) {
                        Storage::disk('public')->delete($value->image_url);
                    }
                    $data_image->each->delete();
                }
                if($request->hasFile('images')){
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

    public function detail($slug){
        try {
            $property = Property::with('images', 'creator')->where('slug', $slug)->first();
            if($property){
                $propertyUnggulan = PropertyUnggulan::where('property_id', $property->id)->first();
                $boolunggulan = $propertyUnggulan ? true : false;
                return response()->json([
                    'message' => 'data found',
                    'status' => 'found',
                    'data' => $property,
                    'is_unggulan' => $boolunggulan,
                    'path' => URL::current()
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
            $property = Property::with('images', 'creator')->paginate(10, ['id','slug','judul','tipe_properti','harga','luas_tanah','kamar_mandi','kamar_tidur','agent_id', 'created_at', 'area']);
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
            $property = AgentProperty::where('agent_id', $request->user()->id)->with('data:id,judul,tipe_properti,harga,luas_tanah,kamar_mandi,kamar_tidur,agent_id,area,created_at', 'data.creator')->paginate(10);
            if($property){
                return response()->json([
                    'message' => 'data found',
                    'status' => 'found',
                    'data' => $property
                ], 200);
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function searchFilter(Request $request){
        $validator = Validator::make($request->all(), [
            'kata_kunci' => 'string',
            'status' => 'string',
            'tipe_properti' => 'array',
            'min_harga' => 'integer',
            'max_harga' => 'integer',
            'min_luas_tanah' => 'integer',
            'max_luas_tanah' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
            'provinsi_id' => 'integer',
            'kota_id' => 'integer',
            'kecamatan_id' => 'integer',
            'is_unggulan' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }
        $property = Property::query();
        if($request->kata_kunci){
            $property->where('judul', 'like', '%'.$request->kata_kunci.'%');
        }
        if($request->status){
            $property->where('status', $request->status);
        }
        if($request->tipe_properti){
            $property->whereIn('tipe_properti', $request->tipe_properti);
        }
        if($request->min_harga){
            $property->where('harga', '>=', $request->min_harga);
        }
        if($request->max_harga){
            $property->where('harga', '<=', $request->max_harga);
        }
        if($request->min_luas_tanah){
            $property->where('luas_tanah', '>=', $request->min_luas_tanah);
        }
        if($request->max_luas_tanah){
            $property->where('luas_tanah', '<=', $request->max_luas_tanah);
        }
        if($request->kamar_tidur){
            $property->where('kamar_tidur', $request->kamar_tidur);
        }
        if($request->kamar_mandi){
            $property->where('kamar_mandi', $request->kamar_mandi);
        }
        if($request->provinsi_id){
            $property->where('provinsi_id', $request->provinsi_id);
        }
        if($request->kota_id){
            $property->where('kota_id', $request->kota_id);
        }
        if($request->kecamatan_id){
            $property->where('kecamatan_id', $request->kecamatan_id);
        }

        if($request->is_unggulan){
            $property->has('unggulan');
        }
        $get= $property->with("creator")->with("images")->paginate(10);
        // dd($property->toSql());
        if($get->total() > 0){
            return response()->json([
                'message' => 'data found',
                'status' => 'found',
                'data' => $get
            ], 200);
        }
        return response()->json([
            'message' => 'data not found',
            'status' => 'error'
        ], 404);
    }

    public function agentPropertyFilter (Request $request){
        $validator = Validator::make($request->all(), [
            'kata_kunci' => 'string',
            'status' => 'string',
            'tipe_properti' => 'string',
            'min_harga' => 'integer',
            'max_harga' => 'integer',
            'min_luas_tanah' => 'integer',
            'max_luas_tanah' => 'integer',
            'kamar_tidur' => 'integer',
            'kamar_mandi' => 'integer',
            'provinsi_id' => 'integer',
            'kota_id' => 'integer',
            'kecamatan_id' => 'integer',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }

        $data = AgentProperty::where('agent_id', $request->user()->id)->whereHas('data' , function($property) use ($request){
            if($request->kata_kunci){
                $property->where('judul', 'like', '%'.$request->kata_kunci.'%');
            }
            if($request->status){
                $property->where('status', $request->status);
            }
            if($request->tipe_properti){
                $property->where('tipe_properti', $request->tipe_properti);
            }
            if($request->min_harga){
                $property->where('harga', '>=', $request->min_harga);
            }
            if($request->max_harga){
                $property->where('harga', '<=', $request->max_harga);
            }
            if($request->min_luas_tanah){
                $property->where('luas_tanah', '>=', $request->min_luas_tanah);
            }
            if($request->max_luas_tanah){
                $property->where('luas_tanah', '<=', $request->max_luas_tanah);
            }
            if($request->kamar_tidur){
                $property->where('kamar_tidur', $request->kamar_tidur);
            }
            if($request->kamar_mandi){
                $property->where('kamar_mandi', $request->kamar_mandi);
            }
            if($request->provinsi_id){
                $property->where('provinsi_id', $request->provinsi_id);
            }
            if($request->kota_id){
                $property->where('kota_id', $request->kota_id);
            }
            if($request->kecamatan_id){
                $property->where('kecamatan_id', $request->kecamatan_id);
            }
        })->with('data')->get('property_id');
        if($data->count() > 0){
            return response()->json([
                'message' => 'data found',
                'status' => 'found',
                'data' => $data
            ], 200);
        }
        return response()->json([
            'message' => 'data not found',
            'status' => 'error'
        ], 404);
    }

    public function share (string $url){
        $share = new Share();
        $link = $share->page($url)
        ->facebook()
        ->twitter()
        ->whatsapp()
        ->telegram()
        ->getRawLinks();

        return response()->json([
            'message' => 'share link',
            'status' => 'found',
            'data' => $link
        ], 200);
    }

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

    public function getNewest(){
        $property = Property::with('images', 'creator')->orderBy('created_at', 'desc')->paginate(6, ['id','slug','judul','tipe_properti','harga','luas_tanah','kamar_mandi','kamar_tidur','agent_id', 'created_at', 'area']);
        return response()->json([
            'message' => 'data found',
            'status' => 'found',
            'data' => $property
        ], 200);
    }
}
