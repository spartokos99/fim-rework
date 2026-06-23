<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolutionForest\FilamentTree\Concern\ModelTree;
use Str;

#[Fillable(['team_id', 'parent_id', 'title', 'slug', 'description', 'order', 'prefix', 'creator_id'])]
class TeamCategory extends Model
{
    use ModelTree;

    protected $casts = [
        'parent_id' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (TeamCategory $category) {
            $category->slug = Str::slug($category->title);
            $category->creator_id = auth()->id();
        });

        static::updating(function (TeamCategory $category) {
            if ($category->isDirty('title')) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(TeamCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(TeamCategory::class, 'parent_id');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'category_id');
    }
}
