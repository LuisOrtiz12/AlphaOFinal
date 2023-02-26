<?php

namespace Database\Seeders;

use App\Models\Contactanos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactanosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Contactanos::factory()->count(3)->create();

    }
}
