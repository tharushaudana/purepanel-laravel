<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'student_id',
        'user_id',
        'mark',
        'recorrected'
    ];
}
