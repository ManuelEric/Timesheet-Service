<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{

    protected $connection = 'mysql_crmv2';
    protected $table = 'tbl_user_roles';

    /**
     * The attributes that should be visible in arrays.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'capacity', // used for mentor
    ];
}
