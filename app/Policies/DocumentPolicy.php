<?php

namespace App\Policies;

use App\Document;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('ADMIN');
    }

    /**
     * Determine whether the user can view the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function view(User $user, Document $document)
    {
        switch ($user){
            case $user->hasRole('ADMIN'):
                return true;
                break;

            case $user->hasRole(['LEADER']):
                return $user->project_id == $document->project_id;
                break;

            case $user->hasRole('WORKER'):
                return $user->project_id == $document->project_id;
                break;

            case $user->hasRole('CLIENT'):
                return $user->project_id == $document->project_id;
                break;

            default:
                return false;
        }
    }

    /**
     * Determine whether the user can create documents.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRoles(['ADMIN', 'LEADER', 'CLIENT']);
    }

    /**
     * Determine whether the user can update the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function update(User $user, Document $document)
    {
        switch ($user){
            case $user->hasRole('ADMIN'):
                return true;
                break;

            case $user->hasRole(['LEADER']):
                return $user->project_id == $document->project_id;
                break;

            case $user->hasRole('CLIENT'):
                return $user->project_id == $document->project_id;
                break;

            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function delete(User $user, Document $document)
    {
        switch ($user){
            case $user->hasRole('ADMIN'):
                return true;
                break;

            case $user->hasRole(['LEADER']):
                return $user->project_id == $document->project_id;
                break;

            case $user->hasRole('CLIENT'):
                return $user->project_id == $document->project_id;
                break;

            default:
                return false;
        }
    }

    /**
     * Determine whether the user can restore the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function restore(User $user, Document $document)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the document.
     *
     * @param  \App\User  $user
     * @param  \App\Document  $document
     * @return mixed
     */
    public function forceDelete(User $user, Document $document)
    {
        //
    }
}
