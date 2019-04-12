<?php

use App\Game;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's truncate our existing records to start from scratch.
        Game::truncate();

        $faker = Factory::create();

        // And now, let's create a few articles in our database:
        for ($i = 0; $i < 50; $i++) {
            Game::create([
                'status' => $faker->boolean,
                'score' => $faker->randomNumber(6),
                'player' => $faker->name,
                'idSeries' => $faker->numberBetween(1, 50),
                'idDifficulty' => $faker->numberBetween(1, 50)
            ]);
        }
    }
}
