<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Traits\MealPlanningReportTrait;

class GetPatientMealPlan extends Command
{
    use MealPlanningReportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meal-plan:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get meal planning every 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Passed this month date to get data
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $response = $this->generateMealPlanningReport($startDate, $endDate);
        if ($response['body']['success']) {
            //Operation with data can be here. , $response['body']
            $this->info('Meal plan fetched as API successfully.');
        } else {
            $this->error('Failed to get meal plan: ' . $response['body']['message']);
        }

        //Task scheduling is done in routes/console.php file in laravel 11. 
    }
}
