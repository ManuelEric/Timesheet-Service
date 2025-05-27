<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The scopes.
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /**
     * The relations.
     */
    public function subject()
    {
        return $this->hasMany(TempUserRoles::class, 'curriculum_id', 'id');
    }
}
