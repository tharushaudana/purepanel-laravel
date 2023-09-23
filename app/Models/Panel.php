<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Panel extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'district_id'
    ];

    public function getUsers() {
        $userIds = $this->getUserIds();
        return User::whereIn('id', $userIds)->get();
    }

    private function getUserIds() {
        $accesses = PanelAccess::where('panel_id', $this->id)->get();

        $ids = [];

        foreach ($accesses as $access) {
            if ($access->user_id == Auth::user()->id) continue;
            array_push($ids, $access->user_id);
        }

        return $ids;
    }
}
