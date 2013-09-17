<?php

namespace ParamountHOA\ParamountHoaApiBundle\Enum;

/**
 * Class OwnerParams
 * @package ParamountHOA\ParamountHoaApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class OwnerParams {

    protected static $enum = [
        'firstName',
        'lastName',
        'emailAddress',
        'password',
        'street',
        'suite',
        'city',
        'state',
        'zipCode',
        'country',
        'unit',
        'phoneNumber'
    ];

    public static function get() {
        return self::$enum;
    }

}