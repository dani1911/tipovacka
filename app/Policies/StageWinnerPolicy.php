<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StageWinner;
use Illuminate\Auth\Access\HandlesAuthorization;

class StageWinnerPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StageWinner');
    }

    public function view(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('View:StageWinner');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StageWinner');
    }

    public function update(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('Update:StageWinner');
    }

    public function delete(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('Delete:StageWinner');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:StageWinner');
    }

    public function restore(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('Restore:StageWinner');
    }

    public function forceDelete(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('ForceDelete:StageWinner');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StageWinner');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StageWinner');
    }

    public function replicate(AuthUser $authUser, StageWinner $stageWinner): bool
    {
        return $authUser->can('Replicate:StageWinner');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StageWinner');
    }

}