<?php

namespace Modules\ContactGroupDetail\Entities;

use Illuminate\Database\Eloquent\Model;

class ContactGroupDetail extends Model
{
    protected $primaryKey = 'contact_group_detail_id';
    protected $fillable = [
        "contact_group_id",
        "contact_id",
    ];
    public $timestamps = false;
}
