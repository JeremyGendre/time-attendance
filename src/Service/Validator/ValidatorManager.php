<?php

namespace App\Service\Validation;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorManager
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @param $object
     * @return void
     */
    public function handleValidation($object)
    {
        $errors = $this->validator->validate($object);

        if(count($errors) > 0){
            throw new BadRequestHttpException();
        }
    }
}
