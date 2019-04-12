<?php

use App\Difficulty;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DifficultiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
//        Difficulty::truncate();

        $faker = Factory::create();

        // And now, let's create a few articles in our database:
        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Difficulty::create([
                'name' => $faker->name,
                'distance' => $faker->randomNumber(3),
                'numberOfPhotos' => $faker->randomNumber(2)
            ]);
        }
    }
}
