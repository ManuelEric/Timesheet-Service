<?php

namespace App\Models;

use App\Observers\ReminderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ReminderObserver::class])]
class Reminder extends Model
{
    use HasFactory;

    public $incrementing = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'timesheet_id',
        'activity_id',
        'times',
        'type',
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

    public function activities()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    /**
     * The scopes.
     */
    public function scopeIsQuotaReminder(Builder $query): void
    {
        $query->whereNotNull('timesheet_id')->whereNull('activity_id');
    }

    public function scopeIsAppointmentReminder(Builder $query): void
    {
        $query->whereNull('timesheet_id')->whereNotNull('activity_id');
    }

}
