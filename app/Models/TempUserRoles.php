<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUserRoles extends Model
{
    use HasFactory;

    protected $table = 'temp_user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'temp_user_id',
        'role',
        'tutor_subject',
        'fee_hours',
        'fee_session',
    ];

    /**
     * The relations.
     *
     * @var array<int, string>
     */ 
    public function temp_user()
    {
        return $this->belongsTo(TempUser::class, 'temp_user_id', 'id');
    }

    public function timesheet()
    {
        return $this->hasMany(Timesheet::class, 'subject_id', 'id');
    }

    /**
     * The scopes.
     */
    public function scopeTutor(Builder $query): void
    {
        $query->where('role', 'Tutor')->whereNotNull('tutor_subject');
    }
}
