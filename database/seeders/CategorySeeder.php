<?php

namespace Database\Seeders;

use App\Models\TrackerCategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Doctor',
            'Dentist',
            'Dermatologist',
        ];

        foreach ($categories as $category) {
            TrackerCategory::updateOrCreate(['name' => $category]);
        }
    }
}
