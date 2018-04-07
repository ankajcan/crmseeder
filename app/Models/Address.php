<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{

    protected $table = 'addresses';

    public $guarded = ['id'];

    protected $fillable = ['address', 'apt', 'zip', 'city', 'state', 'state_id', 'country_id', 'contact_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
