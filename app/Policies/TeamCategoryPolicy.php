<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User as AuthUser;
use App\Models\TeamCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamCategoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return true;
    }

    public function view(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return true;
    }

    public function create(AuthUser $authUser): bool
    {
        return true;
    }

    public function update(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return true;
    }

    public function delete(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return true;
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return false;
    }

    public function restore(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return false;
    }

    public function forceDelete(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return false;
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return false;
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return false;
    }

    public function replicate(AuthUser $authUser, TeamCategory $teamCategory): bool
    {
        return false;
    }

    public function reorder(AuthUser $authUser): bool
    {
        return false;
    }

}