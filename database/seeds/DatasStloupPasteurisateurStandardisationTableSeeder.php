<?php

use Illuminate\Database\Seeder;
use App\Stloup_pasteurisateur_standardisation_data;

class DatasStloupPasteurisateurStandardisationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         
        
        factory(App\Stloup_pasteurisateur_standardisation_data::class, 5)->create();
    }
}
