<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Home Appliances' => 'Manuals for refrigerators, washing machines, dryers, etc.',
            'Electronics' => 'Manuals for TVs, audio systems, computers, etc.',
            'Kitchen Appliances' => 'Manuals for blenders, mixers, toasters, etc.',
            'Gardening Tools' => 'Manuals for lawnmowers, trimmers, etc.',
            'Power Tools' => 'Manuals for drills, saws, sanders, etc.',
            'Vehicles' => 'Manuals for cars, motorcycles, boats, etc.',
            'Office Equipment' => 'Manuals for printers, scanners, fax machines, etc.',
            'Furniture' => 'Manuals for furniture assembly and maintenance',
            'Other' => 'Manuals for items that do not fit into other categories'
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => $description
            ]);
        }
    }
}
