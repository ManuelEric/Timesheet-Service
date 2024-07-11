<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Pivot\Pic;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role',
        'last_activity',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be observes.
     *
     * @var array<int, string>
     */
    protected $observables = [
        'authenticated',
        'logged_out',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = (string) Str::ulid();
        });
    }

    /**
     * Authenticate & fire custom event
     */
    public function authenticate()
    {
        $this->fireModelEvent('authenticated', false);
    }

    /**
     * Logged out & fire custom event
     */
    public function logging_out()
    {
        $this->fireModelEvent('logged_out', false);
    }

    /**
     * The relations.
     *
     * @var array<int, string>
     */

    public function timesheets()
    {
        return $this->belongsToMany(Timesheet::class, 'timesheet_pics', 'user_id', 'timesheet_id')->withTimestamps();
    }

    public function pivot_user()
    {
        return $this->hasMany(Pic::class, 'user_id', 'id');
    }

}
