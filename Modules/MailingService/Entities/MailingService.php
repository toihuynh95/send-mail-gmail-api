<?php

namespace Modules\MailingService\Entities;

use Illuminate\Database\Eloquent\Model;

class MailingService extends Model
{
    protected $primaryKey = 'mailing_service_id';
    protected $fillable = [
        'mailing_service_name',
        'mailing_service_amount'
    ];
    public $timestamps = false;
}
