<?php

namespace App\Services\Api;

use GuzzleHttp\Exception\GuzzleException;

class CourierApi extends BaseApi
{
    /**
     * SessionApi constructor.
     */
    public function __construct()
    {
        parent::__construct(env('COURIER_API_URL'));
    }

    public static function instance()
    {
        return app()->make(self::class);
    }

    public function sendMessage($cell, $message)
    {
        $endPoint = 'sms';
        $method = 'post';
        $params = [
            'cell-number' => $cell,
            'message' => $message
        ];
        $options = [
            'headers' => [
                'token' => env('NOTIFICATION_API_TOKEN')
            ]
        ];
        return json_decode(
            $this->getResponseContent(
                $this->call($method, $endPoint, $params, $options)
            ), true
        );
    }

}
