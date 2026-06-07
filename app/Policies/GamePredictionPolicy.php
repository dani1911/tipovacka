<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GamePrediction;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePredictionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GamePrediction');
    }

    public function view(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('View:GamePrediction');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GamePrediction');
    }

    public function update(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('Update:GamePrediction');
    }

    public function delete(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('Delete:GamePrediction');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GamePrediction');
    }

    public function restore(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('Restore:GamePrediction');
    }

    public function forceDelete(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('ForceDelete:GamePrediction');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GamePrediction');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GamePrediction');
    }

    public function replicate(AuthUser $authUser, GamePrediction $gamePrediction): bool
    {
        return $authUser->can('Replicate:GamePrediction');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GamePrediction');
    }

}