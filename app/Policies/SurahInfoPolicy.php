<?php

namespace App\Policies;

use App\Models\SurahInfo;
use App\Models\User;

class SurahInfoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SurahInfo $surahInfo): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SurahInfo $surahInfo): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SurahInfo $surahInfo): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SurahInfo $surahInfo): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SurahInfo $surahInfo): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }
}
