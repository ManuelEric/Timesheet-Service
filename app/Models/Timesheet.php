<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mentortutor_user_id',
        'mentortutor_name',
        'inhouse_user_id',
        'inhouse_user_name',
        'package_id',
        'notes',
        'meeting_link'
    ];
    
    /**
     * The relations.
     *
     * @var array<int, string>
     */

    public function admin()
    {
        return $this->belongsToMany(User::class, 'timesheet_pics', 'timesheet_id', 'user_id')->withTimestamps();
    }

    public function handle_by()
    {
        return $this->belongsToMany(TempUser::class, 'timesheet_handle_by', 'timesheet_id', 'temp_user_id')->withTimestamps();
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function ref_clientprograms()
    {
        return $this->hasOne(Ref_ClientProgram::class, 'timesheet_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'timesheet_id', 'id');
    }
}
