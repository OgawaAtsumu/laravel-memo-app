<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Category::create([
    'name' => '仕事',
    ]);

    Category::create([
    'name' => '学習',
    ]);

    Category::create([
    'name' => 'プライベート',
    ]);

    Category::create([
    'name' => 'その他',
    ]);
    }
}
