<?php declare(strict_types=1);


namespace CodeCoz\AimAdmin\Contracts\Service;

interface PermissionServiceInterface
{
    function getAllPermission();

    function filterPermissions();

    function savePermission($request);

    function updatePermission($request);

    function deletePermission(int $id);

    function getSinglePermission(int $id);

    function getApplication(): array;

}

