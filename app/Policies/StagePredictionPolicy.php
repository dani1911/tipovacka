<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StagePrediction;
use Illuminate\Auth\Access\HandlesAuthorization;

class StagePredictionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StagePrediction');
    }

    public function view(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('View:StagePrediction');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StagePrediction');
    }

    public function update(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('Update:StagePrediction');
    }

    public function delete(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('Delete:StagePrediction');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:StagePrediction');
    }

    public function restore(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('Restore:StagePrediction');
    }

    public function forceDelete(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('ForceDelete:StagePrediction');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StagePrediction');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StagePrediction');
    }

    public function replicate(AuthUser $authUser, StagePrediction $stagePrediction): bool
    {
        return $authUser->can('Replicate:StagePrediction');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StagePrediction');
    }

}