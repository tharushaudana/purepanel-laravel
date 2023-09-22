<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'panel_id',
        'user_id'
    ];
}
