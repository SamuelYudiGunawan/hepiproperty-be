<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'status',
        'tipe_properti',
        'deskripsi',
        'harga',
        'area',
        'provinsi_id',
        'kota_id',
        'kecamatan_id',
        'luas_tanah',
        'luas_bangunan',
        'kamar_tidur',
        'kamar_mandi',
        'kamar_tidur_pembantu',
        'kamar_mandi_pembantu',
        'listrik',
        'air',
        'sertifikat',
        'posisi_rumah',
        'garasi_dan_carport',
        'kondisi_bangunan',
        'agent_id',
        'slug'
    ];

    protected $appends = [ 'date_deff', 'date', 'path', 'is_highlighted' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'agent_id', 'id');
    }

    public function agents()
    {
        return $this->hasMany(AgentProperty::class);
    }

    public function unggulan()
    {
        return $this->hasOne(PropertyUnggulan::class, 'property_id', 'id');
    }

    public function GetIsHighlightedAttribute()
    {
        if($this->unggulan){
            return $this->unggulan->highlight;
        }
        return false;
    }

    public function getDateDeffAttribute()
    {
        if($this->created_at){
        return $this->created_at->locale('id')->longRelativeToNowDiffForHumans();
        }
    }

    public function getDateAttribute()
    {
        if($this->created_at){
        return $this->created_at->format('d M Y');
        }
    }

    public function getPathAttribute()
    {
        return "/property/detail/slug/" . $this->slug;
    }
}
