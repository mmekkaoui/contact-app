<?php

namespace Database\Seeders;

use App\Models\PhoneType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
           PhoneNumberTypeSeeder::class
        ]);
    }
}
