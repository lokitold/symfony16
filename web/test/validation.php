<?php

require __DIR__.'/../vendor/autoload.php';

$input = [
    'emails' => [
        7 => 'david@panmedia.co.nz',
        12 => 'some@email.add',
    ],
    'user' => 'bob',
    'amount' => 7,
];

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints;
$validator = Validation::createValidator();
$constraint = new Constraints\Collection(array(
    'emails' => new Constraints\All(array(
        new Constraints\Email(),
    )),
    'user' => new Constraints\Regex('/[a-z]/i'),
    'amount' => new Constraints\Range(['min' => 5, 'max' => 10]),
));

$violations = $validator->validateValue($input, $constraint);
echo $violations;