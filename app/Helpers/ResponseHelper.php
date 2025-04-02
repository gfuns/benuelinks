<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function successAuth($token, $customer)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) 200,
            'status'     => "Successful",
            'data'       => [
                'token'     => $token,
                'tokenType' => 'Bearer',
                'agent'     => $customer,
            ],
        ]]);
    }

    public static function success($data)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) 200,
            'status'     => "Successful",
            'data'       => $data,
        ]]);
    }

    public static function successOk($message)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) 200,
            'status'     => "Successful",
            'message'    => $message,
        ]]);
    }

    public static function error($message, $code = 400)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) $code,
            'status'     => "Failed",
            'message'    => $message,
        ]], (int) $code);
    }

    public static function pending($data)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) 202,
            'status'     => "Pending",
            'data'       => $data,
        ]]);
    }

    public static function timeout($message, $code = 408)
    {
        return new JsonResponse(['response' => [
            'statusCode' => (int) $code,
            'status'     => "Request Timeout",
            'message'    => $message,
        ]], (int) $code);
    }
}
