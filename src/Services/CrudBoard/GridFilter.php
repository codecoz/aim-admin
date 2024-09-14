<?php declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodeCoz\AimAdmin\Services\CrudBoard;

use CodeCoz\AimAdmin\Form\AbstractForm;
use CodeCoz\AimAdmin\Collection\ActionCollection;
use Illuminate\Support\Facades\Request;
use CodeCoz\AimAdmin\Field\ButtonField;

 /**
  * This is an abstract form  class for crud board
  *
  * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
  */

  class GridFilter extends AbstractForm
  {
    const CONTAINER_NAME = 'filters';

    public function getActions() : ActionCollection
    {
       return $this->actions;
    }

    public function assignQueryData() : self
    {
       $queryData =  Request::get(self::CONTAINER_NAME,[]);
     //  dd($queryData);
       $fields = $this->getFields();
       foreach($queryData as $field=>$value){
        if($fields->offsetExists($field)) {
         $value &&  $fields->get($field)->setValue($value);
        }
       }
       return $this;
    }

    public function getData(): array
    {
       $data =  Request::get(self::CONTAINER_NAME,[]);
       return array_filter($data);
    }

    public function setActions(array $actions) : static
    {
        $dtos = [];
        foreach($actions as $action) {
            $dto = $action->getDto();
            $dto->isFilterAction() &&  $dtos[] = $dto;
        }
        if(empty($dtos)){
         $actions = [
            ButtonField::init('Search','Search')->createAsFilterSubmitAction()
             ->setIcon('fa-search'),
             ButtonField::init('reset','Reset')->createAsFilterAction()
             ->displayAsButton()->setHtmlAttributes(['type'=>'reset']),
           ];
           foreach($actions as $action) {
            $dto = $action->getDto();
            $dto->isFilterAction() &&  $dtos[] = $dto;
         }
        }
        $this->actions = ActionCollection::init($dtos);
        return $this;
    }


  }
