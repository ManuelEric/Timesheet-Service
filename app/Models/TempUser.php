<?php

namespace App\Models;

use App\Models\Pivot\HandleBy;
use App\Observers\TempUserObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

#[ObservedBy([TempUserObserver::class])]
class TempUser extends Authenticatable implements CanResetPassword
{
    use HasFactory, HasApiTokens, Notifiable;

    public $incrementing = false;
    protected $table = 'temp_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'full_name',
        'email',
        'password',
        'role',
        'inhouse',
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

        /* Register any authentication / authorization services */
        ResetPassword::createUrlUsing(function (TempUser $user, string $token) {
            return env('TIMESHEET_FE_DOMAIN') . '?token=' . $token .'&email=' . $user->email;
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
        return $this->belongsToMany(Timesheet::class, 'timesheet_handle_by', 'temp_user_id', 'timesheet_id')->withTimestamps()->using(HandleBy::class);
    }

    public function roles()
    {
        return $this->hasMany(TempUserRoles::class, 'temp_user_id', 'id');
    }

    public function as_inhouse()
    {
        return $this->hasMany(Timesheet::class, 'inhouse_id', 'uuid');
    }

}
