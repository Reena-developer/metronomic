<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExceptionsLog extends Model
{
    use HasFactory;

    protected $table = 'exceptions_log';

    protected $fillable = [
        'error_message',
        'stack_trace',
        'method',
        'file',
        'created_at',
        'updated_at',
    ];
}
