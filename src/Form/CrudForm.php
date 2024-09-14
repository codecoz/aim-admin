<?php declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Form;

use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Collection\ActionCollection;


/**
 * This is an CRUD form class in crud board. Main purpose of this form is to build form to create DB object
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */
class CrudForm extends AbstractForm
{
    private Request $request;


    public function getActions(): ActionCollection
    {
        return $this->actions->getFormActions();
    }


    public function processData(Request $request)
    {
        $this->request = $request;
        $this->validate();
        return $this->save();
    }

    private function validate()
    {
        $rules = $this->prepareValidationRule();
        $this->request->validate($rules);
    }

    private function prepareValidationRule(): array
    {
        $rules = [];
        foreach ($this->getFields() as $field) {
            $field->getValidationRule() && $rules[$field->getName()] = $field->getValidationRule();
        }
        return $rules;
    }

    private function save()
    {
        $data = [];
        foreach ($this->getFields() as $field) {
            $data[$field->getName()] = $this->request->input($field->getName());
        }
        return $this->saveData($data);
    }
}
