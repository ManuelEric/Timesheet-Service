<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutoff extends Model
{
    use HasFactory;

    protected $table = 'timesheet_cutoff_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'month',
        'from',
        'to',
    ];
    
    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'cutoff_ref_id', 'id');
    }
}
