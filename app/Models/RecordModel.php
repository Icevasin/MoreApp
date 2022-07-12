<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'Record_date',
        'Model_id',
        'Brand_id',
        'Employee_id'
    ];
}
