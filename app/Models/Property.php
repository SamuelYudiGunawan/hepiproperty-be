<?php

namespace App\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $appends = ["date_deff", "date", "path", "is_highlighted"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy(
            "image_index",
            "asc"
        );
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "agent_id", "id");
    }

    public function agents()
    {
        return $this->hasMany(AgentProperty::class);
    }

    public function unggulan()
    {
        return $this->hasOne(PropertyUnggulan::class, "property_id", "id");
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function propertyRenters()
    {
        return $this->hasOne(PropertyRenter::class, "property_id", "id");
    }

    public function GetIsHighlightedAttribute()
    {
        if ($this->unggulan) {
            return $this->unggulan->highlight;
        }
        return false;
    }

    public function getDateDeffAttribute()
    {
        if ($this->created_at) {
            return $this->created_at
                ->locale("id")
                ->longRelativeToNowDiffForHumans();
        }
    }

    public function getDateAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->format("d M Y");
        }
    }

    public function getPathAttribute()
    {
        return "/property/detail/slug/" . $this->slug;
    }
}
