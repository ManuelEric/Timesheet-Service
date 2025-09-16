<?php

namespace App\Models;

use App\Observers\CutOffObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

#[ObservedBy([CutOffObserver::class])]
class Cutoff extends Model
{
    use HasFactory;

    protected $table = 'timesheet_cutoff_history';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'month',
        'from',
        'to',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = (string) Str::ulid();
        });
    }

    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'cutoff_ref_id', 'id');
    }

    /**
     * The scopes.
     */

    public function scopeInBetween(Builder $query, string $start, string $end): void
    {
        $query->where(function ($sub) use ($start, $end) {
            $sub->
                // withinTheCutoffDateRange($start)->
                where(function ($_sub_) use ($start, $end) {
                    //! need to be changed
                    //! with below code, there's a chance that some activities are included
                    $_sub_->where('from', '>=', "{$start} 12:01:00")->where('to', '<=', "{$end} 23:59:59");
                });
        });
    }

    public function scopeWithinTheCutoffDateRange(Builder $query, string $date): void
    {
        $query->whereRaw("'{$date}' BETWEEN `from` and `to`");
    }
}
