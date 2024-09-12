<?php declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Field;

use function Symfony\Component\String\u;

use CodeCoz\AimAdmin\Collection\ActionCollection;
use CodeCoz\AimAdmin\Dto\CrudBoard\ActionDto;


/**
 * This class is for group button creation in crudboard  .
 *
 * @author Muhammad Abdullah Ibne Masud <md.a.ibne.masud@gmail.com>
 */
final class GroupActionField
{
    private ActionDto $dto;
    private ActionCollection $children;

    private function __construct(ActionDto $actionDto)
    {
        $this->dto = $actionDto;
    }

    public function __toString()
    {
        return $this->dto->getName();
    }

    /**
     * @param mixed $label Use FALSE to hide the label; use NULL to autogenerate it
     * @param string|null $icon The full CSS classes of the FontAwesome icon to render (see https://fontawesome.com/v6/search?m=free)
     */
    public static function init(string $name, ?string $label = null, mixed ...$prarms): self
    {
        $dto = new ActionDto();
        $dto->setName($name);
        $dto->setLabel($label);
        $dto->setComponent('aim-admin::crudboard.actions.group');
        return new self($dto);
    }

}
