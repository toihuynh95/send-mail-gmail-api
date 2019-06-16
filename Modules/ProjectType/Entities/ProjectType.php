<?php

namespace Modules\ProjectType\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $primaryKey = 'project_type_id';
    protected $fillable = [
        'project_type_name'
    ];
    public $timestamps = false;
}
