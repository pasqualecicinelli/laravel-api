<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Project;
use App\Models\Type;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //Uso config per prendere i dati "array" dalla cartella config i file in projects.php
        $_projects = config("projects");

        $type_ids = Type::all()->pluck("id");
        $type_ids[] = null;

        foreach ($_projects as $_project) {

            $project = new Project();
            $project->type_id = $faker->randomElement($type_ids);
            $project->fill($_project);
            $project->slug = Str::slug($project->name_prog);
            $project->save();
        }
    }
}