<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyUnggulan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function data()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
}
