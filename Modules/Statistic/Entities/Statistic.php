<?php

namespace Modules\Statistic\Entities;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $primaryKey = 'statistic_id';
    protected $fillable = [
        'statistic_day',
        'statistic_month',
        'statistic_year',
        'project_id'
    ];
    protected $hidden = [
        'statistic_month',
        'project_id',
        'statistic_id',
        'statistic_year'
    ];
    public $timestamps = false;
}
