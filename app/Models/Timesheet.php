<?php

namespace App\Models;

use App\Observers\TimesheetObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([TimesheetObserver::class])]
class Timesheet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'package_id',
        'package_type',
        'detail_package',
        'duration',
        'notes',
    ];
    
    /**
     * The relations.
     *
     * @var array<int, string>
     */

    public function admin()
    {
        return $this->belongsToMany(User::class, 'timesheet_pics', 'timesheet_id', 'user_id')->withTimestamps();
    }

    public function handle_by()
    {
        return $this->belongsToMany(TempUser::class, 'timesheet_handle_by', 'timesheet_id', 'temp_user_id')->withTimestamps();
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function ref_program()
    {
        return $this->hasOne(Ref_Program::class, 'timesheet_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'timesheet_id', 'id');
    }

    /**
     * The scopes.
     * 
     */
    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $program_name = $search['program_name'] ?? false;
        $timesheet_package = $search['timesheet_package'] ?? false;

        $query->
            when( $program_name, function ($_sub_) use ($program_name) {
                $_sub_->whereHas('ref_program', function ($__sub__) use ($program_name) {
                    $__sub__->where('program_name', 'like', '%'.$program_name.'%');
                });
            })->
            when( $timesheet_package, function ($_sub_) use ($timesheet_package) {
                $_sub_->where('package_type', 'like', '%'.$timesheet_package.'%');
            });
    }
}
