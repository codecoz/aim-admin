<?php declare(strict_types=1);


namespace CodeCoz\AimAdmin\Contracts\Service;

interface RoleServiceInterface
{
    function saveRole($request);

    function deleteRole(int $id);

    function getSingleRole(int $id);

    function updateRole($request);

    function getAllRole();

    function getApplication(): array;

}
