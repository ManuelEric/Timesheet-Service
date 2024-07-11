<?php

namespace App\Models\Pivot;

use App\Models\TempUser;
use App\Observers\HandleByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[ObservedBy([HandleByObserver::class])]
class HandleBy extends Pivot
{
    use HasFactory;

    protected $table = 'timesheet_handle_by';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'temp_user_id',
        'timesheet_id',
        'active',
    ];

    /**
     * The events.
     */
    public function stored()
    {
        $this->fireModelEvent('attach', false);
    }

    /**
     * The relations.
     *
     * @var array<int, string>
     */

    public function mentor_tutor()
    {
        return $this->belongsTo(TempUser::class, 'temp_user_id', 'id');
    }
}
