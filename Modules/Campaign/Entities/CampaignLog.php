<?php

namespace Modules\Campaign\Entities;

use Illuminate\Database\Eloquent\Model;

class CampaignLog extends Model
{
    public static $SENT = 1;
    public static $UNSENT = 0;
    public static $FAILURE = 2;
    protected $primaryKey = 'campaign_log_id';
    protected $fillable = [
        'campaign_id',
        'contact_name',
        'contact_email',
        'contact_gender',
        'campaign_log_status',
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->campaign_log_created_at = $model->freshTimestamp();
        });
    }
}
