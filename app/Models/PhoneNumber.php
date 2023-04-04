<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    public function phoneType(){
        return $this->belongsTo(PhoneType::class, 'phone_type_id');
    }
}
