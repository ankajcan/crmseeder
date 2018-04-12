<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Note extends Model
{

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
        'title',
        'content',
        'entity_id',
        'entity_type',
        'user_id'
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
