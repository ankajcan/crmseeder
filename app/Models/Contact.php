<?php

namespace App\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    const TYPE_PERSON = 1;
    const TYPE_ORGANISATION = 2;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    protected $fillable = ['type', 'title', 'name', 'first_name', 'last_name', 'email', 'phone', 'user_id', 'company_id'];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function manageAddress($request)
    {
        $address = $request->get('address');

        if(isset($address['id'])) {
            $this->address->update($address);
        } else {
            Address::create(array_merge(['contact_id' => $this->id],$address));
        }
    }

    public function getFullNameAttribute($value)
    {
        if($this->type == self::TYPE_ORGANISATION) {
            return $this->name;
        } else {
            return $this->first_name . " ". $this->last_name;
        }
    }

    public static function search($request)
    {
        $query = (new Contact())->newQuery();
        $query->select('contacts.*');

        if($request->has('search')) {
            $search = $request->get('search');

            $query->where(function ($query) use ($search) {
                $query->where('contacts.first_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.last_name', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.email', 'LIKE', '%'.$search.'%');
                $query->orWhere('contacts.phone', 'LIKE', '%'.$search.'%');
            });
        }

        $query->orderBy('contacts.created_at', 'desc');

        $query->distinct();

        return $query->paginate();
    }

}
