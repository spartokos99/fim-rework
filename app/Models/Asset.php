<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Str;

#[Fillable(['team_id', 'title', 'slug', 'description', 'variants', 'image', 'category_id', 'tags', 'publish_at', 'hide_at', 'creator_id'])]
class Asset extends Model
{
    public static function booted()
    {
        static::creating(function (Asset $asset) {
            if (auth()->check()) {
                $asset->slug = str()->slug($asset->title);
                $asset->creator_id = auth()->id();
            }
        });

        static::updating(function (Asset $asset) {
            if($asset->isDirty('title')) {
                $asset->slug = Str::slug($asset->title);
            }
        });
    }

    protected $casts = [
        'variants' => 'array',
        'publish_at' => 'datetime',
        'hide_at' => 'datetime',
        'tags' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TeamCategory::class);
    }

    public function publishedStatus(): string|\Illuminate\Support\Carbon
    {
        if ($this->publish_at === null) {
            return 'unpublished';
        }

        if ($this->publish_at && $this->publish_at->isFuture()) {
            return $this->publish_at;
        }

        if ($this->hide_at && $this->hide_at->isPast()) {
            return ($this->publish_at && $this->publish_at->isFuture()) ? $this->publish_at : 'unpublished';
        }

        return 'published';
    }

    public function getPublishedStatusForGroupingAttribute(): string
    {
        $status = $this->publishedStatus();

        if ($status instanceof \Carbon\Carbon) {
            return 'Scheduled';
        }

        return $status === 'published' ? 'Published' : 'Unpublished';
    }
}
