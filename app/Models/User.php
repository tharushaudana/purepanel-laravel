<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'password',
        'level',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*################################ Centers ###############################*/

    public function getCenters() {
        $centerIds = $this->getCenterIds();
        return Center::whereIn('id', $centerIds)->get();
    }

    public function hasAccessToCenter($id) {
        $centerIds = $this->getPanelIds();
        return in_array($id, $centerIds);
    }

    private function getCenterIds() {
        $panels = $this->getPanels();

        $centerIds = [];

        foreach ($panels as $panel) {
            array_push($centerIds, $panel->district_id);
        }

        return $centerIds;
    }

    /*################################ Panels ###############################*/

    public function getPanels() {
        $panelIds = $this->getPanelIds();
        return Panel::whereIn('id', $panelIds)->get();
    }

    public function hasAccessToPanel($id) {
        $panelIds = $this->getPanelIds();
        return in_array($id, $panelIds);
    }

    private function getPanelIds() {
        $accesses = PanelAccess::where('user_id', $this->id)->get();

        $panelIds = [];

        foreach ($accesses as $access) {
            array_push($panelIds, $access['panel_id']);
        }

        return $panelIds;
    }

    /*################################ Level ###############################*/

    public function hasLevel($levels) {
        $levels = explode('|', $levels);
        return in_array($this->level, $levels);
    }
}
