<?php

use App\Ship;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Ship::class, 10)->create()->each(function (Ship $ship) {
            $faker = app('Faker\Generator');
            if ($ship->type == 'medium') {
                $ship->subordinates = \factory(Ship::class, $faker->numberBetween(0, (int)$ship->crews->count() / 3))->state('light')->create();
            }
        });
    }
}
