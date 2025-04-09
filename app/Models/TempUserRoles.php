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
        'curriculum_id',
        'year',
        'head',
        'additional_fee',
        'grade',
        'fee_individual',
        'fee_group',
        'tax',
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

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id', 'id');
    }

    /**
     * The scopes.
     */
    public function scopeTutor(Builder $query): void
    {
        $query->where('role', 'Tutor')->whereNotNull('tutor_subject');
    }

    public function scopeOnSearch(Builder $query, $search = []): void
    {
        $mentor_id = $search['mentor_id'] ?? false;
        $query->
            when( $mentor_id, function ($_sub_) use ($mentor_id) {
                $_sub_->where('temp_user_id', $mentor_id);
            });
    }
}
