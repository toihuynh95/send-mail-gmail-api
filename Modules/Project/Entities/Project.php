<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public static $ACTIVATED = 1;
    public static $DEACTIVATED = 0;
    protected $primaryKey = 'project_id';
    protected $fillable = [
        'customer_id',
        'project_type_id',
        'mailing_service_id',
        'contract_code',
        'project_status',
        'project_name',
        'project_number_email_remaining'
    ];

    public $timestamps = false;
}
