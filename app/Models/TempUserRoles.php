<?php

namespace App\Models;

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
}
