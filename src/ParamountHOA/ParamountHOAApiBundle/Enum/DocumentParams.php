<?php

namespace ParamountHOA\ParamountHoaApiBundle\Enum;

/**
 * Class OwnerParams
 * @package ParamountHOA\ParamountHoaApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class DocumentParams {

    protected static $enum = [
        'path',
        'description',
        'type',
        'archived'
    ];

    public static function get() {
        return self::$enum;
    }

}