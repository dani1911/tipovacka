<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GameAdvancement;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameAdvancementPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GameAdvancement');
    }

    public function view(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('View:GameAdvancement');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GameAdvancement');
    }

    public function update(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('Update:GameAdvancement');
    }

    public function delete(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('Delete:GameAdvancement');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GameAdvancement');
    }

    public function restore(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('Restore:GameAdvancement');
    }

    public function forceDelete(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('ForceDelete:GameAdvancement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GameAdvancement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GameAdvancement');
    }

    public function replicate(AuthUser $authUser, GameAdvancement $gameAdvancement): bool
    {
        return $authUser->can('Replicate:GameAdvancement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GameAdvancement');
    }

}