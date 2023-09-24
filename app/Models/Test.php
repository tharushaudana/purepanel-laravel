<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'center_id',
        'type',
        'name',
        'held_on'
    ];

    public function batch() {
        return $this->belongsTo(Batch::class);
    }

    public function center() {
        return $this->belongsTo(Center::class);
    }

    public function marks() {
        return $this->hasMany(TestMark::class)->orderBy('mark', 'DESC');
    }
}
