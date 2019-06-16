<?php

namespace Modules\Contact\Entities;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $primaryKey = 'contact_id';
    protected $fillable = [
        "customer_id",
        "contact_name",
        "contact_email",
        "contact_gender",
    ];
    public $timestamps = false;
}
