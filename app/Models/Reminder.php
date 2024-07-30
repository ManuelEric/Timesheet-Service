<?php

namespace App\Models;

use App\Observers\ReminderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
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
        'activity_id',
        'times',
        'type',
    ];

    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function activities()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

}
