<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Test;
use Database\Factories\TestFactory;
use Illuminate\Support\Facades\Auth;

class TestsTableSeeder extends Seeder
{
    public function run()
    {
        TestFactory::new()->count(5)->create();
    }
}
