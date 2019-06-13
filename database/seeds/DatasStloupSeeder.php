<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatasStloupSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker) {
        $options = array();

        $time = 0;
        for ($i = 0; $i < 12000; $i++) {
            $time += 2;
            $options['_date'] = $faker->dateTimeInInterval($startDate = '+ ' . $time . ' seconde', $interval = 'now', null);
            factory(\App\Stloup_pasteurisateur_standardisation_data::class, 1)->create($options);
        }
    }

}
