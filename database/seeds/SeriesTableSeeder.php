<?php

use App\Series;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
//        Series::truncate();

        $faker = Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Series::create([
                'city' => $faker->city,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'zoom' => $faker->randomNumber(2)
            ]);
        }
    }
}
