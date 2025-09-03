<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $connection = 'mysql_crmv2';
    protected $table = 'users';
    
    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'id',
        'nip',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone',
        'emergency_contact_phone',
        'emergency_contact_relation_name',
        'datebirth',
        'position_id',
        'password',
        'hiredate',
        'nik',
        'idcard',
        'cv',
        'bank_name',
        'account_name',
        'account_no',
        'npwp',
        'tax',
        'active',
        'health_insurance',
        'empl_insurance',
        'export',
        'notes',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'tbl_user_roles', 'user_id', 'role_id')->using(UserRole::class)->withTimestamps()->withPivot('id', 'user_id', 'role_id', 'capacity');
    }
}
