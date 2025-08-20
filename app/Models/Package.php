<?php

namespace App\Models;

use App\Http\Traits\TranslatePackageCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, TranslatePackageCategory;

    protected $table = 'timesheet_packages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'type_of',
        'package',
        'detail',
        'active',
    ];

    /**
     * The relations.
     *
     * @var array<int, string>
     */
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'package_id', 'id');
    }

    public function ref_programs()
    {
        return $this->hasMany(Ref_Program::class, 'package', 'package');
    }

    /**
     * The scopes.
     */
    public function scopeOnSearch(Builder $query, array $search = []): void
    {
        $category = array_key_exists('category', $search) ? $this->convert($search['category']) : false;

        $query->when($category, function ($sub) use ($category) {
            $sub->where('category', $category);
        });
    }
}
