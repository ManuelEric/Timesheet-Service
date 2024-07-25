<?php

namespace App\Models;

use App\Models\Pivot\HandleBy;
use App\Models\Pivot\Pic;
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
        'inhouse_id',
        'package_id',
        'duration',
        'notes',
        'subject_id',
    ];
    
    /**
     * The relations.
     *
     * @var array<int, string>
     */

    public function admin()
    {
        return $this->belongsToMany(User::class, 'timesheet_pics', 'timesheet_id', 'user_id')->withTimestamps()->using(Pic::class);
    }

    public function handle_by()
    {
        return $this->belongsToMany(TempUser::class, 'timesheet_handle_by', 'timesheet_id', 'temp_user_id')->withTimestamps()->using(HandleBy::class)->withPivot('active');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function ref_program()
    {
        return $this->hasMany(Ref_Program::class, 'timesheet_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'timesheet_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(TempUserRoles::class, 'subject_id', 'id');
    }

    public function inhouse_pic()
    {
        return $this->belongsTo(TempUser::class, 'inhouse_id', 'uuid');
    }

    /**
     * The scopes.
     * 
     */
    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $program_name = $search['program_name'] ?? false;
        $package_id = $search['package_id'] ?? false;
        $keyword = $search['keyword'] ?? false;

        $query->
            when( $program_name, function ($_sub_) use ($program_name) {
                $_sub_->whereHas('ref_program', function ($__sub__) use ($program_name) {
                    $__sub__->where('program_name', 'like', '%'.$program_name.'%');
                });
            })->
            when( $package_id, function ($_sub_) use ($package_id) {
                $_sub_->where('package_id', $package_id);
            })->
            when( $keyword, function ($_sub_) use ($keyword) {
                $_sub_->
                    where( function ($__sub__) use ($keyword) {
                        $__sub__->
                            whereHas('inhouse_pic', function ($___sub___) use ($keyword) {
                                $___sub___->where('full_name', 'like', '%' . $keyword . '%');
                            })->
                            orWhereHas('handle_by', function ($___sub___) use ($keyword) {
                                $___sub___->where('full_name', 'like', '%'. $keyword .'%');
                            })->
                            orWhereHas('ref_program', function ($___sub___) use ($keyword) {
                                $___sub___->where('student_name', 'like', '%'.$keyword.'%')->orWhere('student_school', 'like', '%'.$keyword.'%');
                        });
                    });
            });

    }

    public function scopeHandleBy(Builder $query, string $identifier): void
    {
        
        $query->whereHas('handle_by', function($query) use ($identifier) {
            $query->where('uuid', $identifier);
        });
    }
}
