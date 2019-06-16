<?php

namespace Modules\ContactGroup\Entities;

use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    public static $IS_ACTIVE = 1;
    public static $DEACTIVATED = 0;
    protected $primaryKey = 'contact_group_id';
    protected $fillable = [
        "customer_id",
        "contact_group_name",
        "contact_group_status"
    ];
    public $timestamps = false;
}
