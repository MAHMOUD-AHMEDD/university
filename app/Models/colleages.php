<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class colleages extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['government_id','name','info'];

    public function government()
    {
        return $this->belongsTo(government::class,'government_id')
            ->withTrashed();
    }
    public function years()
    {
        return $this->belongsToMany(years::class,colleages_years::class
        ,'colleage_id','year_id')
            ->withPivot('created_at','updated_at')->as('middle_table');
    }
}
