<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'travle_packages_id','image'
    ];

    protected $hidden=[

    ];

    public function travle_packages(){
        return $this->belongsTo(TravlePackage::class,'travle_packages_id','id');
    }

}
