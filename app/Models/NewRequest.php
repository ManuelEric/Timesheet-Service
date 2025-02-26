<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mentor_id',
        'clientprog_id',
        'invoice_id',
        'student_uuid',
        'student_name',
        'student_school',
        'student_grade',
        'program_name',
        'engagement_type_id',
        'notes'
    ];

    /**
     * Relations
     */
    public function mentor()
    {
        return $this->belongsTo(TempUser::class, 'mentor_id', 'id');
    }

    public function engagementType()
    {
        return $this->belongsTo(EngagementType::class, 'engagement_type_id', 'id');
    }
}
