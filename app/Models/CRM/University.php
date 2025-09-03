<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $connection = 'mysql_crmv2';
    protected $table = 'tbl_univ';

    protected $primaryKey = 'univ_id';

    public $incrementing = false;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var list<string>
     */
    protected $fillable = [
        'univ_id',
        'univ_name',
        // 'tag',
        'univ_address',
        'univ_country',
        'univ_email',
        'univ_phone',
        'early_action',
        'early_decision',
        'regular_deadline',
    ];
}
