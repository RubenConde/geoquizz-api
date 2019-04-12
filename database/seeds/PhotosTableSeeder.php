<?php

use App\Photo;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Photo::truncate();

        $faker = Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Photo::create([
                'description' => $faker->paragraph,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'url' => $faker->url,
                'idSeries' => $faker->numberBetween(1, 50)
            ]);
        }
    }
}
