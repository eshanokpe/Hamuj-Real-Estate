<?php

namespace Database\Seeders;
use App\Models\NeighborhoodCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NeighborhoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Residential', 'Commercial', 'Recreational', 'Industrial', 'Educational'];
        foreach ($categories as $category) {
            NeighborhoodCategory::create(['name' => $category]);
        }
    }
}
