<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhoneTypeResource;
use App\Models\PhoneType;

class PhoneTypesController extends Controller
{
    public function index(){
        return PhoneTypeResource::collection(PhoneType::all());
    }
}
