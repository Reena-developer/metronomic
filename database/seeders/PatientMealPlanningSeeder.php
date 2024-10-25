<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientMealPlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('patient_meal_planning')->truncate();
        
        $faker = \Faker\Factory::create();
        $now = Carbon::now();

        $totalRecords = 2000;
        $batchSize = 200;
        $data = [];
        $existingCombinations = [];

        for ($i = 0; $i < $totalRecords; $i++) {
            $patient_id = $faker->numberBetween(1, 100);
            $planned_date = Carbon::now()->subDays(rand(1, 730));
            
            $combinationKey = "{$patient_id}-{$planned_date->toDateString()}";

            if (!in_array($combinationKey, $existingCombinations)) {
                $total_calories = $faker->randomFloat(2, 1200, 3500);
                $total_fats = $faker->randomFloat(2, 30, 150);
                $total_carbs = $faker->randomFloat(2, 100, 400);
                $total_proteins = $faker->randomFloat(2, 50, 200);
                $is_active = $faker->boolean();
                $created_by = $faker->numberBetween(1, 10);
                $updated_by = $faker->numberBetween(1, 10);

                $data[] = [
                    'patient_id' => $patient_id,
                    'planned_date' => $planned_date,
                    'total_calories' => $total_calories,
                    'total_fats' => $total_fats,
                    'total_carbs' => $total_carbs,
                    'total_proteins' => $total_proteins,
                    'is_active' => $is_active,
                    'created_by' => $created_by,
                    'created_at' => $now,
                    'updated_by' => $updated_by,
                    'updated_at' => $now,
                ];

                $existingCombinations[] = $combinationKey;
            } else {
                $i = $i-1;
            }
            
            if (count($data) >= $batchSize) {
                PatientMealPlanning::insert($data);
                $data = [];
            }

        }

         // Insert, if any remaining records
         if (!empty($data)) {
            PatientMealPlanning::insert($data);
        }
    }
}
