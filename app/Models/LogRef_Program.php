<?php

namespace App\Models;

use App\Observers\LogRef_ProgramObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([LogRef_ProgramObserver::class])]
class LogRef_Program extends Model
{
    use HasFactory;

    protected $table = 'log_ref_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref_program_id',
        'timesheet_id'
    ];
}
