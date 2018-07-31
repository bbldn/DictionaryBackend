<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidateException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class Controller extends BaseController
{
    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return Validator
     */
    protected function getValidator(
        array $data,
        array $rules,
        array $messages = [],
        array $customAttributes = []
    ): Validator
    {
        return ValidatorFacade::make($data, $rules, $messages, $customAttributes);
    }

    /**
     * @param array $data
     * @param array $rules
     * @throws ValidateException
     */
    protected function validate(array $data, array $rules): void
    {
        $validator = $this->getValidator($data, $rules);
        if (true === $validator->fails()) {
            throw new ValidateException(
                implode(' ', $validator->errors()->all())
            );
        }
    }
}
