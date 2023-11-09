<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'tipe',
        'tipe_bangunan',
        'harga',
        'deskripsi',
        'area',
        'luas_tanah',
        'luas_bangunan',
        'kamar_tidur',
        'kamar_mandi',
        'kamar_tidur_pembantu',
        'kamar_mandi_pembantu',
        'listrik',
        'air',
        'sertifikat',
        'hadap',
        'garasi_dan_carport',
        'furnished',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
