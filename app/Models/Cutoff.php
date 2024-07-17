<?php

namespace App\Models;

use App\Observers\CutOffObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
