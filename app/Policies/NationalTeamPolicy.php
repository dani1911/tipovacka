<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\NationalTeam;
use Illuminate\Auth\Access\HandlesAuthorization;

class NationalTeamPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:NationalTeam');
    }

    public function view(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('View:NationalTeam');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:NationalTeam');
    }

    public function update(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('Update:NationalTeam');
    }

    public function delete(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('Delete:NationalTeam');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:NationalTeam');
    }

    public function restore(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('Restore:NationalTeam');
    }

    public function forceDelete(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('ForceDelete:NationalTeam');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:NationalTeam');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:NationalTeam');
    }

    public function replicate(AuthUser $authUser, NationalTeam $nationalTeam): bool
    {
        return $authUser->can('Replicate:NationalTeam');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:NationalTeam');
    }

}