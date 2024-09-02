<?php

namespace Database\Seeders;

use Database\Factories\TestAttemptFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestAttemptSeeder extends Seeder
{

    public function run()
    {
        TestAttemptFactory::new()->count(10)->create();
    }
}
