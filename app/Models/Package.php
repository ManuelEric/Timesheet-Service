<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'timesheet_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_of',
        'package',
        'detail',
    ];

    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'package_id', 'id');
    }
}
