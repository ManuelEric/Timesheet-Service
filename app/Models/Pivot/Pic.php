<?php

namespace App\Models\Pivot;

use App\Models\User;
use App\Observers\PicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([PicObserver::class])]
class Pic extends Pivot
{
    use HasFactory;

    protected $table = 'timesheet_pics';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'timesheet_id',
    ];

    /**
     * The relations.
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
