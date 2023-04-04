<?php

namespace Database\Seeders;

use App\Models\PhoneType;
use Illuminate\Database\Seeder;

class PhoneNumberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneType::insert([
            ['type' => 'HOME'],
            ['type' => 'WORK'],
            ['type' => 'MOBILE'],
        ]);
    }
}
