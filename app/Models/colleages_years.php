<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class colleages_years extends Model
{
    use HasFactory;
    protected $fillable=[
        'colleage_id','year_id'
    ];
    public function year()
    {
        $this->belongsTo(years::class,'year_id');
    }
}
