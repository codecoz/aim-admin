<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Support\Facades;

use Illuminate\Support\Facades\Facade;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudBoardInterface;

/**
 * This is a facade  class for crud grid
 *
 * @author CodeCoz <contact@codecoz.com>
 */
class CrudBoardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return CrudBoardInterface::class;
    }
}
