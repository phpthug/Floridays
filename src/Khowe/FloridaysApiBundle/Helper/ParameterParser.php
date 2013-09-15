<?php

namespace Khowe\FloridaysApiBundle\Helper;

class ParameterParser {

    public static function parseParameters($request, $parameters, $config) {
        $data = [];

        foreach($parameters as $param => $value) {
            if($config[$value]['required'] && $request->request->get($value, null) == null) {
                return false;
            }

            $data[$value] = $request->request->get($value, null);
        }

        return $data;
    }

}