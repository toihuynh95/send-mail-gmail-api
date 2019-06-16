<?php

namespace Modules\Campaign\Entities;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public static $WAIT_SEND = 0;
    public static $FINISH = 1;
    protected $primaryKey = 'campaign_id';
    protected $fillable = [
        'project_id',
        'campaign_name',
        'campaign_email_id',
        'campaign_email_name',
        'campaign_title',
        'campaign_content',
        'campaign_attach_file',
        'campaign_schedule',
        'campaign_status',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->campaign_created_at = $model->freshTimestamp();
        });
    }
}
