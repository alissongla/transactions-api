<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;

class UtilToolsClient extends Client
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => config('client.url.util'),
            'timeout' => 2.0,
        ]);
    }

    public function getAuthorization()
    {
        try {
            $auth = $this->get('v2/authorize');
            $response = json_decode($auth->getBody()->getContents(), true);

            return $response['data']['authorization'];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getNotifyServiceStatus()
    {
        try {
            $this->post('v1/notify');

            return true;
        } catch (\Exception $e) {

            return false;
        }

    }
}
