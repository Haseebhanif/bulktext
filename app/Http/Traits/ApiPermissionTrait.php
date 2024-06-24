<?php

namespace App\Http\Traits;

trait ApiPermissionTrait
{




    public function permissionCheck($permission,$user): bool
    {

        return match ($permission) {
            "read" => $user->tokenCan('read'),
            "update" => $user->tokenCan('update'),
            "create" => $user->tokenCan('create'),
            "delete" => $user->tokenCan('delete'),
            default => false,
        };
    }

}
