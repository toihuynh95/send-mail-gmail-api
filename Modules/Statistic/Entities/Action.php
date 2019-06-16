<?php

namespace Modules\Statistic\Entities;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $primaryKey = 'action_id';
    protected $fillable = [
        'project_id',
        'action_time',
        'action_value'
    ];
    public $timestamps = false;
}
