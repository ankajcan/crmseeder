<?php

namespace App\Http\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            "id" => $user->id,
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "roles" => $user->roles,
            "stripe_customer_id" => $user->stripe_customer_id
        ];
    }

}