<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneType;

class PhoneTypesController extends Controller
{
    public function index(){
        return PhoneType::all();
    }
}
