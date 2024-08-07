<?php

namespace App\Http\Controllers\Properties;

use App\Models\Property;
use Jorenvh\Share\Share;
use Mavinoo\Batch\Batch;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AgentProperty;
use App\Models\PropertyImage;
use App\Models\PropertyUnggulan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\PropertyRenter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "judul" => "required|string",
                "status" => "required|string|in:dijual,disewakan",
                "tipe_properti" => "required|string",
                "deskripsi" => "required|string",
                "harga" => "required|integer",
                "area" => "required|string",
                "provinsi_id" => "integer",
                "kota_id" => "integer",
                "kecamatan_id" => "integer",
                "luas_tanah" => "integer",
                "luas_bangunan" => "integer",
                "kamar_tidur" => "integer",
                "kamar_mandi" => "integer",
                "kamar_tidur_pembantu" => "integer",
                "kamar_mandi_pembantu" => "integer",
                "listrik" => "integer",
                "air" => "string",
                "sertifikat" => "string",
                "hadap" => "string",
                "garasi" => "integer",
                "carport" => "integer",
                "lebar_depan_bangunan" => "integer",
                "jumlah_lantai" => "integer",
                "tipe_harga_sewa" => "string",
                "periode_sewa" => "string",
                "nama_vendor" => "string",
                "no_hp_vendor" => "string",
                "alamat" => "string",
                "kondisi_bangunan" => "string",
                "images" => "array",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ],

            [
                // message for validation status
                "status.in" => "status must be dijual or disewakan",
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }

        $max_slug = Property::where("judul", $request->judul)->count();
        $slug = Str::slug($request->judul . "-" . $max_slug, "-");

        try {
            DB::beginTransaction();
            $property = Property::create(
                $validator
                    ->safe()
                    ->merge([
                        "slug" => $slug,
                        "agent_id" => $request->user()->id,
                    ])
                    ->except("images")
            );
            if ($request->hasFile("images") && $property) {
                foreach ($request->file("images") as $key => $value) {
                    $image_name[] = [
                        "property_id" => $property->id,
                        "image_url" => Storage::disk("public")->put(
                            "images",
                            $value
                        ),
                    ];
                }
                PropertyImage::insert($image_name);
            }
            AgentProperty::create([
                "agent_id" => $request->user()->id,
                "property_id" => $property->id,
            ]);
            DB::commit();
            return response()->json(
                [
                    "message" => "data created",
                    "status" => "created",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => $th->getMessage(),
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function createWithAgent(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "judul" => "required|string",
                "status" => "required|string|in:dijual,disewakan",
                "tipe_properti" => "required|string",
                "deskripsi" => "required|string",
                "harga" => "required|integer",
                "area" => "required|string",
                "provinsi_id" => "integer",
                "kota_id" => "integer",
                "kecamatan_id" => "integer",
                "luas_tanah" => "integer",
                "luas_bangunan" => "integer",
                "kamar_tidur" => "integer",
                "kamar_mandi" => "integer",
                "kamar_tidur_pembantu" => "integer",
                "kamar_mandi_pembantu" => "integer",
                "listrik" => "integer",
                "air" => "string",
                "sertifikat" => "string",
                "posisi_rumah" => "string",
                "garasi_dan_carport" => "integer",
                "kondisi_bangunan" => "string",
                "images" => "array",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ],

            [
                // message for validation status
                "status.in" => "status must be dijual or disewakan",
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }
        $request->merge([
            "agent_id" => $id,
        ]);

        $max_slug = Property::where("judul", $request->judul)->count();
        $slug = Str::slug($request->judul . "-" . $max_slug, "-");

        $request->merge([
            "slug" => $slug,
        ]);

        try {
            DB::beginTransaction();
            $property = Property::create($request->except("images"));
            if ($request->hasFile("images") && $property) {
                foreach ($request->file("images") as $key => $value) {
                    $image_name[] = [
                        "property_id" => $property->id,
                        "image_url" => Storage::disk("public")->put(
                            "images",
                            $value
                        ),
                    ];
                }
                PropertyImage::insert($image_name);
            }
            AgentProperty::create([
                "agent_id" => $request->user()->id,
                "property_id" => $property->id,
            ]);
            DB::commit();
            return response()->json(
                [
                    "message" => "data created",
                    "status" => "created",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when creating data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "judul" => "string",
                "status" => "string|in:dijual,disewakan",
                "tipe_properti" => "string",
                "deskripsi" => "string",
                "harga" => "integer",
                "area" => "string",
                "provinsi_id" => "integer",
                "kota_id" => "integer",
                "kecamatan_id" => "integer",
                "luas_tanah" => "integer",
                "luas_bangunan" => "integer",
                "kamar_tidur" => "integer",
                "kamar_mandi" => "integer",
                "kamar_tidur_pembantu" => "integer",
                "kamar_mandi_pembantu" => "integer",
                "listrik" => "integer",
                "air" => "string",
                "sertifikat" => "string",
                "hadap" => "string",
                "garasi" => "integer",
                "carport" => "integer",
                "lebar_depan_bangunan" => "integer",
                "jumlah_lantai" => "integer",
                "tipe_harga_sewa" => "string",
                "periode_sewa" => "string",
                "nama_vendor" => "string",
                "no_hp_vendor" => "string",
                "alamat" => "string",
                "kondisi_bangunan" => "string",
                "images" => "array",
                "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            ],

            [
                // message for validation status
                "status.in" => "status must be dijual or disewakan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->messages(),
                    "status" => "error",
                ],
                400
            );
        }
        $property = Property::find($id);

        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }

        if ($request->judul && $request->judul != $property->judul) {
            $max_slug = Property::where("judul", $request->judul)->count();
            $slug = Str::slug($request->judul . "-" . $max_slug, "-");
            $request->merge([
                "slug" => $slug,
            ]);
        }
        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where("property_id", $id)->get();
            $is_in_array = in_array(
                $request->user()->id,
                $agent_property->pluck("agent_id")->toArray()
            );
            if ($is_in_array || $request->user()->hasRole(["admin", "owner"])) {
                $property->update($request->except("images"));
                if ($request->hasFile("images")) {
                    $data_image = PropertyImage::where(
                        "property_id",
                        $id
                    )->get();
                    foreach ($data_image as $key => $value) {
                        Storage::disk("public")->delete($value->image_url);
                    }
                    $data_image->each->delete();
                    foreach ($request->file("images") as $key => $value) {
                        $image_name[] = [
                            "property_id" => $property->id,
                            "image_url" => Storage::disk("public")->put(
                                "images",
                                $value
                            ),
                        ];
                    }
                    PropertyImage::insert($image_name);
                    if (
                        $request->hasAny([
                            "tipe_harga_sewa",
                            "periode_sewa",
                            "nama_vendor",
                            "no_hp_vendor",
                            "alamat",
                        ])
                    ) {
                        $request->merge([
                            "property_id" => $id,
                        ]);

                        $renter = PropertyRenter::where(
                            "property_id",
                            $id
                        )->first();
                        if ($renter) {
                            $renter->update(
                                $request->only([
                                    "tipe_harga_sewa",
                                    "periode_sewa",
                                    "nama_vendor",
                                    "no_hp_vendor",
                                    "alamat",
                                    "property_id",
                                ])
                            );
                        } else {
                            PropertyRenter::create(
                                $request->only([
                                    "tipe_harga_sewa",
                                    "periode_sewa",
                                    "nama_vendor",
                                    "no_hp_vendor",
                                    "alamat",
                                    "property_id",
                                ])
                            );
                        }
                    }
                }
                DB::commit();
                return response()->json(
                    [
                        "message" => "data updated",
                        "status" => "updated",
                    ],
                    200
                );
            }
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => $th->getMessage(),
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function updateWithImageID(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "judul" => "string",
            "status" => "string",
            "tipe_properti" => "string",
            "deskripsi" => "string",
            "harga" => "integer",
            "area" => "string",
            "provinsi_id" => "integer",
            "kota_id" => "integer",
            "kecamatan_id" => "integer",
            "luas_tanah" => "integer",
            "luas_bangunan" => "integer",
            "kamar_tidur" => "integer",
            "kamar_mandi" => "integer",
            "kamar_tidur_pembantu" => "integer",
            "kamar_mandi_pembantu" => "integer",
            "listrik" => "integer",
            "air" => "string",
            "sertifikat" => "string",
            "posisi_rumah" => "string",
            "garasi_dan_carport" => "integer",
            "kondisi_bangunan" => "string",
            "images" => "array",
            "images.*" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "image_id" => "array",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->messages(),
                    "status" => "error",
                ],
                400
            );
        }

        if (!Property::find($id)) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }

        if ($request->judul && $request->judul != Property::find($id)->judul) {
            $max_slug = Property::where("judul", $request->judul)->count();
            $slug = Str::slug($request->judul . "-" . $max_slug, "-");
            $request->merge([
                "slug" => $slug,
            ]);
        }
        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where("property_id", $id)->get();
            $is_in_array = in_array(
                $request->user()->id,
                $agent_property->pluck("agent_id")->toArray()
            );
            if ($is_in_array || $request->user()->hasRole(["admin", "owner"])) {
                $property->update($request->except("images"));
                if ($request->image_id) {
                    $data_image = PropertyImage::whereIn(
                        "id",
                        $request->image_id
                    )->get();
                    foreach ($data_image as $key => $value) {
                        Storage::disk("public")->delete($value->image_url);
                    }
                    $data_image->each->delete();
                }
                if ($request->hasFile("images")) {
                    foreach ($request->file("images") as $key => $value) {
                        $image_name[] = [
                            "property_id" => $property->id,
                            "image_url" => Storage::disk("public")->put(
                                "images",
                                $value
                            ),
                        ];
                    }
                    PropertyImage::insert($image_name);
                }
                DB::commit();
                return response()->json(
                    [
                        "message" => "data updated",
                        "status" => "updated",
                    ],
                    200
                );
            }
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when updating data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $property = Property::find($id);
            $agent_property = AgentProperty::where("property_id", $id)->get();
            $is_in_array = in_array(
                $request->user()->id,
                $agent_property->pluck("agent_id")->toArray()
            );
            if ($is_in_array || $request->user()->hasRole(["admin", "owner"])) {
                $data_image = PropertyImage::where("property_id", $id)->get();
                foreach ($data_image as $key => $value) {
                    Storage::disk("public")->delete($value->image_url);
                }
                $property->delete();
                DB::commit();
                return response()->json(
                    [
                        "message" => "data deleted",
                        "status" => "deleted",
                    ],
                    200
                );
            }
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when deleting data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function detail($slug)
    {
        try {
            $property = Property::with(
                "images",
                "creator",
                "kota",
                "kecamatan",
                "provinsi"
            );
            if (Auth::check()) {
                $property->with("propertyRenters");
            }
            $property = $property->where("slug", $slug)->first();
            if ($property) {
                $propertyUnggulan = PropertyUnggulan::where(
                    "property_id",
                    $property->id
                )->first();
                $boolunggulan = $propertyUnggulan ? true : false;
                return response()->json(
                    [
                        "message" => "data found",
                        "status" => "found",
                        "data" => $property,
                        "is_unggulan" => $boolunggulan,
                        "path" => URL::current(),
                    ],
                    200
                );
            }
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => "error when getting data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function getPaginate()
    {
        try {
            $property = Property::orderBy(DB::raw("RAND(1234)"))->with(
                "images",
                "creator"
            );

            // dd($property);
            if (Auth::check()) {
                $property->with("propertyRenters");
            }
            $property = $property->paginate(10, [
                "id",
                "slug",
                "judul",
                "tipe_properti",
                "harga",
                "luas_tanah",
                "kamar_mandi",
                "kamar_tidur",
                "agent_id",
                "created_at",
                "area",
            ]);
            if ($property) {
                return response()->json(
                    [
                        "message" => "data found",
                        "status" => "found",
                        "data" => $property,
                    ],
                    200
                );
            }
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "message" => $th->getMessage(),
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function getPaginateByAgent(Request $request)
    {
        try {
            $property = AgentProperty::where("agent_id", $request->user()->id)
                ->with(
                    "data:id,judul,tipe_properti,harga,luas_tanah,kamar_mandi,kamar_tidur,agent_id,area,created_at",
                    "data.creator",
                    "data.propertyRenters"
                )
                ->paginate(10);
            if ($property) {
                return response()->json(
                    [
                        "message" => "data found",
                        "status" => "found",
                        "data" => $property,
                    ],
                    200
                );
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function searchFilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kata_kunci" => "string",
            "status" => "string",
            "tipe_properti" => "array",
            "min_harga" => "integer",
            "max_harga" => "integer",
            "min_luas_tanah" => "integer",
            "max_luas_tanah" => "integer",
            "kamar_mandi" => "integer",
            "min_kamar_tidur" => "integer",
            "max_kamar_tidur" => "integer",
            "min_luas_bagunan" => "integer",
            "max_luas_bagunan" => "integer",
            "agent_id" => "integer",
            "provinsi_id" => "integer",
            "kota_id" => "integer",
            "kecamatan_id" => "integer",
            "is_unggulan" => "boolean",
            "is_highlight" => "boolean",
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->messages(),
                    "status" => "error",
                ],
                400
            );
        }
        $property = Property::query();
        if ($request->kata_kunci) {
            $property->where("judul", "like", "%" . $request->kata_kunci . "%");
        }
        if ($request->status) {
            $property->where("status", $request->status);
        }
        if ($request->tipe_properti) {
            $property->whereIn("tipe_properti", $request->tipe_properti);
        }
        if ($request->min_harga) {
            $property->where("harga", ">=", $request->min_harga);
        }
        if ($request->max_harga) {
            $property->where("harga", "<=", $request->max_harga);
        }
        if ($request->min_luas_tanah) {
            $property->where("luas_tanah", ">=", $request->min_luas_tanah);
        }
        if ($request->max_luas_tanah) {
            $property->where("luas_tanah", "<=", $request->max_luas_tanah);
        }
        if ($request->min_kamar_tidur) {
            $property->where("kamar_tidur", ">=", $request->min_kamar_tidur);
        }
        if ($request->max_kamar_tidur) {
            $property->where("kamar_tidur", "<=", $request->max_kamar_tidur);
        }
        if ($request->min_luas_bangunan) {
            $property->where(
                "luas_bangunan",
                ">=",
                $request->min_luas_bangunan
            );
        }
        if ($request->max_luas_bangunan) {
            $property->where(
                "luas_bangunan",
                "<=",
                $request->max_luas_bangunan
            );
        }
        if ($request->kamar_mandi) {
            $property->where("kamar_mandi", $request->kamar_mandi);
        }
        if ($request->provinsi_id) {
            $property->where("provinsi_id", $request->provinsi_id);
        }
        if ($request->kota_id) {
            $property->where("kota_id", $request->kota_id);
        }
        if ($request->kecamatan_id) {
            $property->where("kecamatan_id", $request->kecamatan_id);
        }

        if ($request->is_unggulan) {
            $property->has("unggulan");
        }
        if ($request->agent_id) {
            $property->where("agent_id", $request->agent_id);
        }

        if ($request->is_highlight) {
            $property->whereHas("unggulan", function (Builder $query) {
                $query->where("highlight", 1);
            });
        }
        $get = $property->with("creator")->with("images")->paginate(10);
        // dd($property->toSql());
        if ($get->total() > 0) {
            return response()->json(
                [
                    "message" => "data found",
                    "status" => "found",
                    "data" => $get,
                ],
                200
            );
        }
        return response()->json(
            [
                "message" => "data not found",
                "status" => "error",
            ],
            404
        );
    }

    public function agentPropertyFilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "kata_kunci" => "string",
            "status" => "string",
            "tipe_properti" => "string",
            "min_harga" => "integer",
            "max_harga" => "integer",
            "min_luas_tanah" => "integer",
            "max_luas_tanah" => "integer",
            "kamar_tidur" => "integer",
            "kamar_mandi" => "integer",
            "provinsi_id" => "integer",
            "kota_id" => "integer",
            "kecamatan_id" => "integer",
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }

        $data = AgentProperty::where("agent_id", $request->user()->id)
            ->whereHas("data", function ($property) use ($request) {
                if ($request->kata_kunci) {
                    $property->where(
                        "judul",
                        "like",
                        "%" . $request->kata_kunci . "%"
                    );
                }
                if ($request->status) {
                    $property->where("status", $request->status);
                }
                if ($request->tipe_properti) {
                    $property->where("tipe_properti", $request->tipe_properti);
                }
                if ($request->min_harga) {
                    $property->where("harga", ">=", $request->min_harga);
                }
                if ($request->max_harga) {
                    $property->where("harga", "<=", $request->max_harga);
                }
                if ($request->min_luas_tanah) {
                    $property->where(
                        "luas_tanah",
                        ">=",
                        $request->min_luas_tanah
                    );
                }
                if ($request->max_luas_tanah) {
                    $property->where(
                        "luas_tanah",
                        "<=",
                        $request->max_luas_tanah
                    );
                }
                if ($request->kamar_tidur) {
                    $property->where("kamar_tidur", $request->kamar_tidur);
                }
                if ($request->kamar_mandi) {
                    $property->where("kamar_mandi", $request->kamar_mandi);
                }
                if ($request->provinsi_id) {
                    $property->where("provinsi_id", $request->provinsi_id);
                }
                if ($request->kota_id) {
                    $property->where("kota_id", $request->kota_id);
                }
                if ($request->kecamatan_id) {
                    $property->where("kecamatan_id", $request->kecamatan_id);
                }
            })
            ->with(
                "data",
                "data.images",
                "data.creator",
                "data.kota",
                "data.provinsi",
                "data.kecamatan"
            )
            ->get("property_id");
        if ($data->count() > 0) {
            return response()->json(
                [
                    "message" => "data found",
                    "status" => "found",
                    "data" => $data,
                ],
                200
            );
        }
        return response()->json(
            [
                "message" => "data not found",
                "status" => "error",
            ],
            404
        );
    }

    public function share(string $url)
    {
        $share = new Share();
        $link = $share
            ->page($url)
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return response()->json(
            [
                "message" => "share link",
                "status" => "found",
                "data" => $link,
            ],
            200
        );
    }

    public function getNewest()
    {
        $property = Property::with("images", "creator")
            ->orderBy("created_at", "desc")
            ->paginate(6, [
                "id",
                "slug",
                "judul",
                "tipe_properti",
                "harga",
                "luas_tanah",
                "kamar_mandi",
                "kamar_tidur",
                "agent_id",
                "created_at",
                "area",
            ]);
        return response()->json(
            [
                "message" => "data found",
                "status" => "found",
                "data" => $property,
            ],
            200
        );
    }

    public function getImages($propertyID)
    {
        $property = Property::find($propertyID);
        if ($property) {
            $images = PropertyImage::where("property_id", $propertyID)
                ->orderBy("image_index")
                ->get();
            return response()->json(
                [
                    "message" => "data found",
                    "status" => "found",
                    "data" => $images,
                ],
                200
            );
        }
        return response()->json(
            [
                "message" => "data not found",
                "status" => "error",
            ],
            404
        );
    }

    public function uploadImages(Request $request, $propertyID)
    {
        /**
         *
         *  $images= [
         *      {"file": "image1",
         *     "image_index": 1},
         *     {"file": "image2",
         *    "image_index": 2}
         *  ]
         *
         *
         *
         * */
        $validator = Validator::make(
            $request->all(),
            [
                "images" => "required|array",
                "images.*.file" =>
                    "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                "images.*.image_index" => "required_with:images.*.file|integer",
            ],
            [
                "images.*.file" => [
                    "required" => "image file is required",
                    "image" => "image file must be an image",
                    "mimes" => "image file must be jpeg, png, jpg, gif, svg",
                    "max" => "image file max size is 2048",
                ],
                "images.*.image_index" => [
                    "required" => "image_index is required",
                    "integer" => "image_index must be an integer",
                ],
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }
        $property = Property::find($propertyID);
        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }
        $image_name = [];

        try {
            DB::beginTransaction();
            foreach ($request->images as $key => $value) {
                $image_name[] = [
                    "property_id" => $propertyID,
                    "image_url" => Storage::disk("public")->put(
                        "images",
                        $value["file"]
                    ),
                    "image_index" => $value["image_index"],
                ];
            }
            $data = PropertyImage::insert($image_name);
            DB::commit();
            return response()->json(
                [
                    "message" => "data uploaded",
                    "status" => "created",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when creating data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function deleteImages(Request $request, $propertyID, $image_id)
    {
        $property = Property::find($propertyID);
        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }
        $image = PropertyImage::find($image_id);
        if (!$image) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }
        try {
            DB::beginTransaction();
            Storage::disk("public")->delete($image->image_url);
            $image->delete();
            DB::commit();
            return response()->json(
                [
                    "message" => "data deleted",
                    "status" => "deleted",
                ],
                200
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when deleting data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function deleteImagesBatch(Request $request, $propertyID)
    {
        $validator = Validator::make($request->all(), [
            "image_id" => "required|array",
            "image_id.*" => "required|integer",
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }
        $property = Property::find($propertyID);
        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }
        $images = PropertyImage::whereIn("id", $request->image_id)->get();
        try {
            DB::beginTransaction();
            foreach ($images as $key => $value) {
                Storage::disk("public")->delete($value->image_url);
            }
            $images->each->delete();
            DB::commit();
            return response()->json(
                [
                    "message" => "data deleted",
                    "status" => "deleted",
                ],
                200
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when deleting data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function updateImage(Request $request, $propertyID)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "images" => "required|array",
                "images.*.id" => "required|integer",
                "images.*.file" =>
                    "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                "images.*.image_index" => "required_with:images.*.file|integer",
            ],
            [
                "images.*.file" => [
                    "required" => "image file is required",
                    "image" => "image file must be an image",
                    "mimes" => "image file must be jpeg, png, jpg, gif, svg",
                    "max" => "image file max size is 2048",
                ],
                "images.*.id" => [
                    "required" => "id is required",
                    "integer" => "id must be an integer",
                ],
                "images.*.image_index" => [
                    "required" => "image_index is required",
                    "integer" => "image_index must be an integer",
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }

        $property = Property::find($propertyID);
        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }

        $image_name = [];
        $deleted_image = [];

        try {
            DB::beginTransaction();
            foreach ($request->images as $key => $value) {
                $image_name[] = [
                    "id" => $value["id"],
                    "property_id" => $propertyID,
                    "image_url" => Storage::disk("public")->put(
                        "images",
                        $value["file"]
                    ),
                    "image_index" => $value["image_index"],
                ];
                $deleted_image[] = $value["id"];
            }

            $deleted_image_data = PropertyImage::whereIn(
                "id",
                $deleted_image
            )->get();

            foreach ($deleted_image_data as $key => $value) {
                Storage::disk("public")->delete($value->image_url);
            }

            $data = PropertyImage::upsert(
                $image_name,
                ["id"],
                ["image_url", "image_index"]
            );
            DB::commit();
            return response()->json(
                [
                    "message" => "data uploaded",
                    "status" => "created",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => "error when creating data",
                    "status" => "error",
                ],
                400
            );
        }
    }

    public function updateImageIndex(Request $request, $propertyID)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "images" => "required|array",
                "images.*.id" => "required|integer",
                "images.*.image_index" => "required_with:images.*.id|integer",
            ],
            [
                "images.*.id" => [
                    "required" => "id is required",
                    "integer" => "id must be an integer",
                ],
                "images.*.image_index" => [
                    "required" => "image_index is required",
                    "integer" => "image_index must be an integer",
                ],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->errors()->first(),
                    "status" => "error",
                ],
                400
            );
        }

        $property = Property::find($propertyID);
        if (!$property) {
            return response()->json(
                [
                    "message" => "data not found",
                    "status" => "error",
                ],
                404
            );
        }

        $image_name = [];

        try {
            DB::beginTransaction();
            foreach ($request->images as $key => $value) {
                $image_name[] = [
                    "id" => $value["id"],
                    "property_id" => $propertyID,
                    "image_index" => $value["image_index"],
                ];
            }

            $index = "id";
            $instance = new PropertyImage();

            Batch()->update($instance, $image_name, $index);

            DB::commit();
            return response()->json(
                [
                    "message" => "data uploaded",
                    "status" => "created",
                ],
                201
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => $th->getMessage(),
                    "status" => "error",
                ],
                400
            );
        }
    }
}
