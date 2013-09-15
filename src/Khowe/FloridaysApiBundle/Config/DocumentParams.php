<?php

namespace Khowe\FloridaysApiBundle\Config;

/**
 * Class OwnerParams
 * @package Khowe\FloridaysApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class DocumentParams {

    protected static $enum = [
        'path' => ['required' => true],
        'description' => ['required' => true],
        'type' => ['required' => true],
        'archived' => ['required' => true]
    ];

    public static function get() {
        return self::$enum;
    }

}