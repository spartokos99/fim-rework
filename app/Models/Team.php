<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

#[Fillable(['name', 'slug', 'description', 'image', 'owner_id', 'color', 'settings'])]
class Team extends Model implements HasAvatar
{
    protected $casts = [
        'settings' => 'array',
    ];

    public static function booted()
    {
        static::creating(function (Team $team) {
            $team->slug = str()->slug($team->name);
            $team->owner_id = auth()->id();
        });

        static::updating(function (Team $team) {
            if ($team->isDirty('name')) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(TeamCategory::class);
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFilamentAvatarUrl(): string|null
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return null;
    }
}
