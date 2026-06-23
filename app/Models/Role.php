<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role as SpatieRole;

#[Fillable(['name', 'guard_name', 'team_id'])]
class Role extends SpatieRole
{
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
