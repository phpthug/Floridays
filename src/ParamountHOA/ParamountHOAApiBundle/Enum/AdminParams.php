<?php

namespace ParamountHOA\ParamountHoaApiBundle\Enum;

/**
 * Class OwnerParams
 * @package ParamountHOA\ParamountHoaApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class AdminParams {

    protected static $enum = [
        'firstName',
        'lastName',
        'emailAddress',
        'password',
        'isActive',
        'isSuperAdmin'
    ];

    public static function get() {
        return self::$enum;
    }

}