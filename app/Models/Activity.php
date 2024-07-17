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
        'fee_hours',
        'additional_fee',
        'time_spent',
        'meeting_link',
        'status',
        'cutoff_status',
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

    /**
     * The scopes.
     */
    public function scopeUnpaid(Builder $query): void
    {
        $query->where('cutoff_status', 'unpaid');
    }

    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $query->whereHas('timesheet', function ($sub) use ($search) {
            $sub->onSearch($search);
        });
    }
}
