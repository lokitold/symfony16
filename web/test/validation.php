<?php

require __DIR__.'/../../vendor/autoload.php';

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;

$validator = Validation::createValidator();

$violations = $validator->validate('Bernhadsssrd', new Length(array('min' => 10)));

echo "<pre>";
var_dump($violations);
echo "</pre>";