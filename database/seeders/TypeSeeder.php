<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $labels = [
            "front-end",
            "back-end",
            "full-stack"
        ];

        foreach ($labels as $label) {
            $type = new Type();
            $type->developed_part = $label;
            $type->save();
        }
    }
}