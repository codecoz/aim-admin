<?php

declare(strict_types=1);


namespace CodeCoz\AimAdmin\Contracts\Service;

interface MenuServiceInterface
{
    function getAllMenu();

    function saveMenu($request);

    function updateMenu($request);

    function deleteMenu(string $id);

    function singleMenu(int $id): \stdClass;

    function keyPairParentID();

    function getApplication(): array;

    function getAllMergedMenuForUser(int $applicationID, array $userMenu): array;

}
