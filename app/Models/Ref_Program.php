<?php

namespace App\Models;

use App\Observers\Ref_ProgramObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([Ref_ProgramObserver::class])]
class Ref_Program extends Model
{
    use HasFactory;

    protected $table = 'ref_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'clientprog_id',
        'schprog_id',
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
     * The scopes.
     * 
     */
    public function scopeWhereWetherB2C_B2B(Builder $query, $category, ?string $clientprog_id, ?string $schprog_id)
    {
        $query->where('category', $category)->
            when($category == 'b2c', function ($sub) use ($clientprog_id) {
                $sub->where('clientprog_id', $clientprog_id);
            }, function ($sub) use ($schprog_id) {
                $sub->where('schprog_id', $schprog_id);
            });
    }
     
    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $program_name = $search['program_name'] ?? false;
        $keyword = $search['keyword'] ?? false;

        $query->
            when( $program_name, function ($_sub_) use ($program_name) {
                $_sub_->where('program_name', 'like', '%'.$program_name.'%');
            })->
            when( $keyword, function ($_sub_) use ($keyword) {
                $_sub_->
                    where(function ($__sub__) use ($keyword) {
                        $__sub__->
                            where('student_name', 'like', '%'.$keyword.'%')->
                            orWhere('student_school', 'like', '%'.$keyword.'%');
                    });
            });
    }
}
