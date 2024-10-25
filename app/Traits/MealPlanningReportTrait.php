<?php

namespace App\Traits;

use App\Models\PatientMealPlanning;
use Carbon\Carbon;
use App\Models\ExceptionsLog;

trait MealPlanningReportTrait
{
    public function generateMealPlanningReport($startDate, $endDate)
    {
        try {
            // Fetch grouped meal planning records with averages and between start and end dates
            $mealPlanningRecords = PatientMealPlanning::whereBetween('planned_date', [$startDate, $endDate])
                ->selectRaw('patient_id, YEAR(planned_date) as year, MONTH(planned_date) as month, 
                    AVG(total_calories) as avg_calories, AVG(total_fats) as avg_fats, 
                    AVG(total_carbs) as avg_carbs, AVG(total_proteins) as avg_proteins, 
                    COUNT(planned_date) as planned_days_count')
                ->groupBy('year', 'month', 'patient_id')
                ->orderBy('year')
                ->orderBy('month')
                ->get();

            $report = [];

            foreach ($mealPlanningRecords as $record) {
                // Format month and year for display
                $monthName = Carbon::createFromDate($record->year, $record->month, 1)->format('F Y');
                $totalDaysInMonth = Carbon::createFromDate($record->year, $record->month, 1)->daysInMonth;
                
                // Generate all days in the month for the patient
                $allDaysInMonth = collect(range(1, $totalDaysInMonth))->map(fn($day) => Carbon::createFromDate($record->year, $record->month, $day)->format('Y-m-d'));
                
                // get planned days in the month for the patient
                $plannedDays = PatientMealPlanning::where('patient_id', $record->patient_id)
                    ->whereYear('planned_date', $record->year)
                    ->whereMonth('planned_date', $record->month)
                    ->pluck('planned_date')
                    ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'));
                
                // Get not planned meal days in the month for the patient
                $skippedDays = $allDaysInMonth->diff($plannedDays);
                
                // Calculate percentage
                $plannedPercentage = $totalDaysInMonth > 0 ? ($record->planned_days_count / $totalDaysInMonth) * 100 : 0;

                // Generate result response
                $report[] = [
                    'month' => $monthName,
                    'patient_id' => $record->patient_id, // This is not in doc response but i have added.
                    'planned_percentage' => round($plannedPercentage, 2) . ' %',
                    'avg_total_calories' => round($record->avg_calories, 2),
                    'avg_total_carbs' => round($record->avg_carbs, 2),
                    'avg_total_protein' => round($record->avg_proteins, 2),
                    'avg_total_fat' => round($record->avg_fats, 2),
                    'days_planning_skipped' => $skippedDays->map(fn($day) => Carbon::parse($day)->format('d F Y'))->values()->all(),
                ];
            }

            return [
                'body' => [
                    'success' => true,
                    'message' => 'Data fetched successfully.',
                    'data' => $report,
                    
                ],
                'statusCode' => 200
            ];
        } catch (\Exception $e) {
            ExceptionsLog::create([
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'method' => 'generateMealPlanningReport',
                'file' => 'MealPlanningReportTrait',
            ]);

            return [
                'body' => [
                    'success' => false,
                    'message' => 'An error occurred while generating the report.',
                    'error' => $e->getMessage(),
                ],
                'statusCode' => 200
            ];
        } 
    }
}
