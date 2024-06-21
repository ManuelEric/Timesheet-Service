<?php

namespace App\Models;

use App\Observers\TempUserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

#[ObservedBy([TempUserObserver::class])]
class TempUser extends Model
{
    use HasFactory, HasApiTokens;

    public $incrementing = false;
    protected $table = 'temp_users';

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
         return $this->belongsToMany(Timesheet::class, 'timesheet_handle_by', 'temp_user_id', 'timesheet_id')->withTimestamps();
     }

}
