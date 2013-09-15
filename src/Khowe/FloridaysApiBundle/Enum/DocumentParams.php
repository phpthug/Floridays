<?php

namespace Khowe\FloridaysApiBundle\Enum;

/**
 * Class OwnerParams
 * @package Khowe\FloridaysApiBundle\Enum
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