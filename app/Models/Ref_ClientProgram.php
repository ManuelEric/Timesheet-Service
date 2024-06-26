<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ref_ClientProgram extends Model
{
    use HasFactory;

    protected $table = 'ref_clientprograms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clientprog_id',
        'invoice_id',
        'student_name',
        'student_school',
        'program_name',
        'timesheet_id',
    ];

    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class, 'timesheet_id', 'id');
    }

    /**
     * Scope a query to only include users of a given type.
     */
    public function scopeOnSearch(Builder $query, array $keyword = []): void
    {
        $program_name_key = $keyword['program_name'] ?? null;
        $timesheet_package_key = $keyword['timesheet_package'] ?? null;

        $query->
            when( $program_name_key, function ($_sub_) use ($program_name_key) {
                $_sub_->where('program_name', 'like', '%'.$program_name_key.'%');
            })->
            when( $timesheet_package_key, function ($_sub_) use ($timesheet_package_key) {
                $_sub_->whereHas('timesheet.package', function ($__sub__) use ($timesheet_package_key) {
                    $__sub__->where('package', 'like', '%'.$timesheet_package_key.'%');
                });
            });
    }
}
