<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class FakeTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->count(30)->create(); 
       
        /*$faker = \Faker\Factory::create();
        for($i=1 ; $i<=100;$i++){
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                
            ]);
        }*/
    }
}
