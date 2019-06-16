<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $primaryKey = 'template_id';
    protected $fillable = [
        'template_name',
        'template_content',
    ];
    public $timestamps = false;
}
