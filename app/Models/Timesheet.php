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

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'timesheet_id', 'id');
    }

    public function scopeHasNotBeenReminded(Builder $query): void
    {
        $query->doesntHave('reminders');
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
        $mentor_id = $search['mentor_id'] ?? false;

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
            })->
            when( $mentor_id, function ($_sub_) use ($search) {
                $_sub_->whereHas('subject', function ($__sub__) use ($search) {
                    $__sub__->onSearch($search);
                });
            });

    }

    public function scopeHandleBy(Builder $query, string $identifier): void
    {        
        $query->whereHas('handle_by', function($sub) use ($identifier) {
            $sub->where('uuid', $identifier);
        });
    }

    public function scopeExpiresInHours(Builder $query, int $hours = 1): void
    {
        $minutes = $hours * 60;
        $query->whereRaw("duration - sum_activity_time_based_on_timesheet(id) = {$minutes}");
    }

    public function scopeOnSession(Builder $query): void
    {
        /* user auth information */
        $isAdmin = auth('sanctum')->user()->is_admin;
        
        $query->when( !$isAdmin, function ($_sub_) {

            $tempUserUuid = auth('sanctum')->user()->uuid;

            $_sub_->
                where('inhouse_id', $tempUserUuid)->
                orWhere(function ($__sub__) use ($tempUserUuid) {
                    $__sub__->handleBy($tempUserUuid);
                });
        });
    }

    public function scopeFilterCutoff(Builder $query, array $search = []): void
    {
        $cutoff_start = $search['cutoff_start'] ?? false;
        $cutoff_end = $search['cutoff_end'] ?? false;

        $query->when( $cutoff_start && $cutoff_end, function ($_sub_) use ($search) {
            $_sub_->whereHas('activities', function ($__sub__) use ($search) {
                $__sub__->onSearch($search);
            });
        });
    }

    public function scopeNewest(Builder $query): void
    {
        $query->orderBy('created_at', 'DESC');
    }
}
