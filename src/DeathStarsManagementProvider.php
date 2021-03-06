<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 16/12/2018
 * Time: 19:12
 */

namespace Bloom\DeathStarsManagement;

use Bloom\DeathStarsManagement\Data\Crew;
use Bloom\DeathStarsManagement\Data\Ship;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DeathStarsManagementProvider extends ServiceProvider
{

    public function boot(): void
    {

    }

    public function register(): void
    {
        $this->registerFactories();
        $this->registerRoutes();
    }

    private function registerFactories(): void
    {
        /**
         * @var Factory $factory
         */
        $factory = app(Factory::class);
        $models = collect([
            ['name' => 'TIE/D Defender', 'max' => 1, 'type' => 'light'],
            ['name' => 'V-wing', 'max' => 1, 'type' => 'light'],
            ['name' => 'VT-49 Decimator', 'max' => 1, 'type' => 'light'],
            ['name' => 'Chasseur TIE', 'max' => 1, 'type' => 'light'],
            ['name' => 'Canonnière d\'assaut TIO/BA', 'max' => 15, 'type' => 'light'],
            ['name' => 'qaz-class Star Destroyer', 'max' => 5000, 'type' => 'medium'],
            ['name' => 'Gozanti-class Assault Carrier', 'max' => 1500, 'type' => 'medium'],
            ['name' => 'battlecruisers', 'max' => 1500, 'type' => 'medium'],
            ['name' => 'Croiseur de classe Consular', 'max' => 3000, 'type' => 'medium'],
            ['name' => 'Destroyer Stellaire de classe Venator', 'max' => 2500, 'type' => 'medium'],
            ['name' => 'Interdictor ', 'max' => 5000, 'type' => 'medium'],
        ]);

        $factory->define(Crew::class, function (Generator $faker) {
            return [
                'code' => $faker->randomNumber(5),
                'name' => $faker->name,
                'job'  => $faker->jobTitle
            ];
        });
        $factory->define(Ship::class, function (Generator $faker) use ($models) {
            $code = strtoupper($faker->randomLetter . $faker->randomLetter . '-' . $faker->randomNumber(3) . '-' . $faker->randomLetter . $faker->randomLetter);
            $model = $faker->randomElement($models->toArray());
            /**
             * @var Crew[]|Collection $crews
             */
            $min_crew = (int)($model['max'] * 0.1);
            if ($min_crew < 1) $min_crew = 1;
            $crews = \factory(Crew::class, $faker->numberBetween($min_crew, $model['max']))->make();
            $crews[0]->job = 'Pilote';

            return [
                'code'  => $code,
                'model' => $model['name'],
                'type'  => $model['type'],
                'crews' => $crews
            ];
        });

        $factory->state(Ship::class, 'light', function (Generator $faker) use ($models) {
            $code = strtoupper($faker->randomLetter . $faker->randomLetter . '-' . $faker->randomNumber(3) . '-' . $faker->randomLetter . $faker->randomLetter);
            $model = $faker->randomElement($models->where('type', '=', 'light')->toArray());
            /**
             * @var Crew[]|Collection $crews
             */
            $min_crew = (int)($model['max'] * 0.1);
            if ($min_crew < 1) $min_crew = 1;
            $crews = \factory(Crew::class, $faker->numberBetween($min_crew, $model['max']))->make();
            if($min_crew > 1) {
                for($i = 0; $i<$faker->numberBetween(1, $crews->count() * 0.1); $i++) {
                    $crews[$i]->job = 'Pilote';
                }
            }

            return [
                'code'  => $code,
                'model' => $model['name'],
                'type'  => 'light',
                'crews' => $crews
            ];
        });
    }

    private function registerRoutes(): void
    {
        Route::group(['prefix' => 'ships'], function () {

            Route::get('/new', function () {
                return factory(Ship::class, request('number', 1))->make();
            });

            Route::get('/', function () {
                return factory(Ship::class, 10)->make()->each(function (Ship $ship) {
                    $faker = app('Faker\Generator');
                    if ($ship->type == 'medium') {
                        $ship->subordinates = \factory(Ship::class, $faker->numberBetween(0, (int)$ship->crews->count() / 3))->state('light')->make();
                    }
                });
            });
        });
    }
}
