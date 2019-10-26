<?php
namespace App\Utils;

use Symfony\Component\Validator\ConstraintViolationList;

/**
 *
 */
class AppUtils
{
    public static function filter_integer_variable($number, $options)
    {
        return filter_var(
            $number,
            FILTER_VALIDATE_INT,
            array(
                'options' => $options
            )
        );
    }

    public static function buildMessageFromConstraintViolationList(ConstraintViolationList $violations)
    {
        $message = '';
        foreach ($violations as $violation) {
            $message = $violation->getMessage();
        }
        return $message;
    }
}
