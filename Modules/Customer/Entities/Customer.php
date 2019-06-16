<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = "customer_id";
    const CREATED_AT = 'customer_created_at';
    protected $fillable = [
        "user_id",
        "customer_name",
        "customer_gender",
        "customer_email",
        "customer_phone",
        "customer_address",
    ];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->customer_created_at = $model->freshTimestamp();
        });
    }
}
