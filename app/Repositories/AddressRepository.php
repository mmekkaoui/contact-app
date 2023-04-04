<?php

namespace App\Repositories;

use App\Models\User;

class AddressRepository
{
    public function createMany(User $user, $data){
        return $user->addresses()->createMany($data);
    }

    public function updateOrCreate(User $user, $addresses){
        foreach ($addresses as $address){
            $user->addresses()->updateOrCreate([
                'id' => $address['id']
            ], [
                'address_line' => $address['address_line'],
                'pincode' => $address['pincode']
            ]);
        }
        $user
            ->addresses()
            ->whereNotIn('id', array_map(fn($item) => $item['id'], $addresses))
            ->delete();
    }
}