<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRenter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
