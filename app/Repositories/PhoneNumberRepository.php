<?php

namespace App\Repositories;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PhoneNumberRepository
{
    public function createMany(User $user, $data){
        return $user->phoneNumbers()->createMany($data);
    }

    public function updateOrCreate(User $user, $phoneNumbers){
        foreach ($phoneNumbers as $phoneNumber){
            $user->phoneNumbers()->updateOrCreate([
                'id' => $phoneNumber['id']
            ], [
                'phone_type_id' => $phoneNumber['phone_type_id'],
                'phone_number' => $phoneNumber['phone_number']
            ]);
        }
        $user
            ->phoneNumbers()
            ->whereNotIn('id', array_map(fn($item) => $item['id'], $phoneNumbers))
            ->delete();
    }
}