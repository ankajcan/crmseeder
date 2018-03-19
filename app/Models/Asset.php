<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Asset extends Model
{
    CONST USER_TYPE_AVATAR = 1;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'entity_id',
        'entity_type',
        'type'
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return env('AWS_S3_BASE').'/'.env('AWS_S3_BUCKET').'/'.$this->path;
    }

    public function getThumbAttribute()
    {
        $path = explode("/",$this->path);
        $path[count($path) - 1] = "250x250/".end($path);
        return env('AWS_S3_BASE').'/'.env('AWS_S3_BUCKET').'/'.implode('/',$path);
    }

}
