<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Asset extends Model
{
    CONST USER_TYPE_AVATAR = 1;
    CONST CONTACT_TYPE_IMAGE = 2;

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
        'file_type',
        'type',
        'size',
        'user_id'
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return env('AWS_S3_BASE').'/'.env('AWS_S3_BUCKET').'/'.$this->path;
    }

    public function getFileTypeAttribute()
    {
        if(strpos($this->name, '.png') !== false || strpos($this->name, '.jpg') !== false || strpos($this->name, '.jpeg') !== false) {
            return "image";
        } else {
            return "file";
        }
    }

    public function getThumbPathAttribute()
    {
        $path = explode("/",$this->path);
        $path[count($path) - 1] = "thumb/".end($path);
        return implode('/',$path);
    }

    public function getThumbAttribute()
    {
        $s3 = App::make('aws')->createClient('s3');
        if(!$s3->doesObjectExist(env('AWS_S3_BUCKET'),$this->thumb_path)) {
            return $this->url;
        };

        return env('AWS_S3_BASE').'/'.env('AWS_S3_BUCKET').'/'.$this->thumb_path;
    }

}
