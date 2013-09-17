<?php

namespace ParamountHOA\ParamountHoaApiBundle\Config;

/**
 * Class OwnerParams
 * @package ParamountHOA\ParamountHoaApiBundle\Enum
 * @author  Kenneth Howe <khowe@ea.com>
 */
class OwnerParams {

    protected static $config = [
        'firstName' => ['required' => true],
        'lastName' => ['required' => true],
        'emailAddress' => ['required' => true],
        'password' => ['required' => true],
        'street' => ['required' => true],
        'suite' => ['required' => false],
        'city' => ['required' => true],
        'state' => ['required' => true],
        'zipCode' => ['required' => true],
        'country' => ['required' => true],
        'unit' => ['required' => false],
        'phoneNumber' => ['required' => true]
    ];

    public static function get() {
        return self::$config;
    }

}