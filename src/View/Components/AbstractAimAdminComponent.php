<?php declare(strict_types=1);

/*
 * This file is part of the Aim Admin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\View\Components;

use Illuminate\View\Component;
use  CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudBoardInterface;


/**
 * this is a base component class of AimAdmin platform.
 *
 * @author CodeCoz <contact@codecoz.com>
 */
abstract class  AbstractAimAdminComponent extends Component
{

    public function __construct(private CrudBoardInterface $crudBoard)
    {
    }

    public function getCrudBoard(): CrudBoardInterface
    {
        return $this->crudBoard;
    }

}
