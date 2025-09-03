<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    use HasFactory;

    protected $connection = 'mysql_crmv2';
    protected $table = 'tbl_user_subjects';

    /**
     * The attributes that should be visible in arrays.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'user_role_id',
        'subject_id',
        'curriculum',
        'fee_individual',
        'fee_group',
        'grade',
        'additional_fee',
        'agreement',
        'head',
        'start_date',
        'end_date',
        'year',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'id');
    }

    public function user_roles()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id')->with('role');
    }
}
