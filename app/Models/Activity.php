<?php

namespace App\Models;

use App\Observers\ActivityObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ActivityObserver::class])]
class Activity extends Model
{
    use HasFactory;

    protected $table = 'timesheet_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'timesheet_id',
        'activity',
        'description',
        'start_date',
        'end_date',
        'tax',
        'fee_hours',
        'additional_fee',
        'bonus_fee',
        'time_spent',
        'meeting_link',
        'status',
        'cutoff_status',
        'cutoff_ref_id',
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

    public function cutoff_history()
    {
        return $this->belongsTo(Cutoff::class, 'cutoff_ref_id', 'id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'activity_id', 'id');
    }

    /**
     * The scopes.
     */
    public function scopeUnpaid(Builder $query): void
    {
        # the activity has to be finished to be selected as unpaid
        # not yet meaning unpaid
        $query->where('status', 1)->where('cutoff_status', 'not yet')->whereNotNull('end_date');
    }

    public function scopePaid(Builder $query): void
    {
        # paid meaning completed
        $query->where('status', 1)->where('cutoff_status', 'completed')->whereNotNull('cutoff_ref_id');
    }

    public function scopeActivityNotRunningYet(Builder $query): void
    {
        $query->where('status', 0)->where('cutoff_status', 'not yet');;
    }

    public function scopeCompleted(Builder $query): void
    {
        $query->where('status', 1);
    }

    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $cutoff_start = $search['cutoff_start'] ?? false;
        $cutoff_end = $search['cutoff_end'] ?? false;

        $query->whereHas('timesheet', function ($sub) use ($search) {
            $sub->onSearch($search);
        })->when($cutoff_start && $cutoff_end, function ($sub) use ($cutoff_start, $cutoff_end) {
            $sub->whereHas('cutoff_history', function ($_sub_) use ($cutoff_start, $cutoff_end) {
                $_sub_->inBetween($cutoff_start, $cutoff_end);
            });
        });
    }

    public function scopeDayBeforeStart(Builder $query, int $day): void
    {
        $query->whereRaw("DATEDIFF(start_date, now()) = {$day}");
    }

    public function scopeHasNotBeenReminded(Builder $query): void
    {
        $query->doesntHave('reminders');
    }

    public function scopeOnSession(Builder $query): void
    {
        /* user auth information */
        $isAdmin = (bool) auth('sanctum')->user()->is_admin;

        $query->when(!$isAdmin, function ($_sub_) {

            $tempUserUuid = auth('sanctum')->user()->uuid;

            $_sub_->whereHas('timesheet', function ($__sub__) use ($tempUserUuid) {
                $__sub__->where('inhouse_id', $tempUserUuid)->orWhere(function ($__sub__) use ($tempUserUuid) {
                    $__sub__->handleBy($tempUserUuid);
                });
            });
        });
    }
}
