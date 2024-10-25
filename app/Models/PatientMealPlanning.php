<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMealPlanning extends Model
{
    use SoftDeletes;
    protected $table = 'patient_meal_planning';
    protected $fillable = [
        'patient_id',
        'planned_date',
        'total_calories',
        'total_fats',
        'total_carbs',
        'total_proteins',
        'is_active',
        'created_by',
        'updated_by',
    ];
}
