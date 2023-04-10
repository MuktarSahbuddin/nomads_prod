<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'travle_packages_id','users_id','additional_visa' ,'transaction_total', 
        'transaction_status' ];

    protected $hidden=[

    ];

    public function details(){
        return $this->hasMany(TransactionDetail::class,'transactions_id','id');
    }
    public function travle_packages(){
        return $this->belongsTo(TravlePackage::class,'travle_packages_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'users_id','id');
    }

}
