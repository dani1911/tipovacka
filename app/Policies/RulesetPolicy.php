<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Ruleset;
use Illuminate\Auth\Access\HandlesAuthorization;

class RulesetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Ruleset');
    }

    public function view(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('View:Ruleset');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Ruleset');
    }

    public function update(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('Update:Ruleset');
    }

    public function delete(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('Delete:Ruleset');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Ruleset');
    }

    public function restore(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('Restore:Ruleset');
    }

    public function forceDelete(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('ForceDelete:Ruleset');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Ruleset');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Ruleset');
    }

    public function replicate(AuthUser $authUser, Ruleset $ruleset): bool
    {
        return $authUser->can('Replicate:Ruleset');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Ruleset');
    }

}