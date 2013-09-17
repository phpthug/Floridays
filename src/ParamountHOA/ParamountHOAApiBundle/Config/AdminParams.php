<?php

namespace ParamountHOA\ParamountHoaApiBundle\Config;

/**
 * Class OwnerParams
 * @package ParamountHOA\ParamountHoaApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class AdminParams {

    protected static $config = [
        'firstName' => ['required' => true],
        'lastName' => ['required' => true],
        'emailAddress' => ['required' => true],
        'password' => ['required' => true],
        'isActive' => ['required' => true],
        'isSuperAdmin' => ['required' => true]
    ];

    public static function get() {
        return self::$config;
    }

}