<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStream extends Model
{
    use HasFactory;

    protected $connection = 'mysql_crmv2';

    protected $fillable = [
        'id',
        'user_role_id',
        'stream_id',
        'engagement_type_id',
        'package',
        'fee_individual',
        'grade',
        'additional_fee',
        'agreement',
        'head',
        'start_date',
        'end_date',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class, 'stream_id', 'id');
    }

    public function user_roles()
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id')->with('role');
    }
}
