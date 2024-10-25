<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\GetRecordsByDateRangeRequest;
use App\Models\PatientMealPlanning;
use Carbon\Carbon;
use App\Traits\MealPlanningReportTrait;
/**
 * @OA\Info(title="Patient Meal Planning API", version="0.1")
 * @OA\Server(
 *     url="http://localhost/metronomic/public",
 *     description="Local server"
 * )
 */
class PatientMealPlanningController extends Controller
{
    use MealPlanningReportTrait;
    /**
     * @OA\Post(
     *     path="/api/v1/meal-plan/list",
     *     tags={"mealPlanning"},
     *     summary="Get meal planning records by date range",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"start_date", "end_date"},
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-01", description="Start date for meal planning records."),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-01-31", description="End date for meal planning records.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true, description="Indicates if the request was successful."),
     *             @OA\Property(property="message", type="string", example="Report generated successfully.", description="Response message."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="month", type="string", example="July 2024", description="The month of the report."),
     *                     @OA\Property(property="patient_id", type="integer", example=1, description="The ID of the patient."),
     *                     @OA\Property(property="planned_percentage", type="string", example="12.9 %", description="Percentage of planned meals."),
     *                     @OA\Property(property="avg_total_calories", type="number", format="float", example=1875.57, description="Average total calories consumed."),
     *                     @OA\Property(property="avg_total_carbs", type="number", format="float", example=280.56, description="Average total carbohydrates consumed."),
     *                     @OA\Property(property="avg_total_protein", type="number", format="float", example=151.01, description="Average total proteins consumed."),
     *                     @OA\Property(property="avg_total_fat", type="number", format="float", example=89.89, description="Average total fats consumed."),
     *                     @OA\Property(property="days_planning_skipped", type="array", 
     *                         @OA\Items(type="string", example="01 July 2024", description="List of days where meal planning was skipped.")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false, description="Indicates that the request was not successful."),
     *             @OA\Property(property="message", type="string", example="Validation errors occurred.", description="Error message."),
     *             @OA\Property(property="errors", type="object", description="Detailed validation errors.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false, description="Indicates that the request was not successful."),
     *             @OA\Property(property="message", type="string", example="An error occurred while generating the report.", description="Error message."),
     *             @OA\Property(property="error", type="string", example="Internal Server Error", description="Detailed error message (optional).")
     *         )
     *     )
     * )
     */
    public function getRecordsByDateRange(GetRecordsByDateRangeRequest $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $respone = $this->generateMealPlanningReport($startDate, $endDate);
        return response()->json($respone['body'], $respone['statusCode']);
    }
}
