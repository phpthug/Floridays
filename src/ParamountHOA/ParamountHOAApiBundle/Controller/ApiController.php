<?php

namespace ParamountHOA\ParamountHoaApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller {

    protected function returnError($message = null)
    {
        return $this->returnResponse([], 400, $message, true);
    }

    protected function returnResponse(array $data, $responseCode = 200, $message = null, $isError = false)
    {
        return new JsonResponse([
            'success' => ! $isError,
            'message' => $message,
            'data' => $data
        ]);
    }

}