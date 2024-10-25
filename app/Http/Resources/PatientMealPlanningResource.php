<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientMealPlanningResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'month' => $this->month ?? null,  
            'planned_percentage' => $this->planned_percentage,  
            'avg_total_calories' => (float) $this->total_calories, 
            'avg_total_carbs' => (float) $this->total_carbs, 
            'avg_total_protein' => (float) $this->total_proteins, 
            'avg_total_fat' => (float) $this->total_fats, 
            'days_planning_skipped' => $this->days_planning_skipped
        ];
    }
}
