<?php

namespace App\Services\BukaSend;

use App\Models\LogBukaSend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class BukaSendService
{
    protected $app_id;

    function __construct()
    {
        $this->app_id = config('services.weather.app_id');
    }

    public function SendRequestBukaSend($url, $data, $method = 'post')
    {
        $url = $this->host . $url;
        $token = $this->getToken();
        if ($method == 'post') {
            $response = $this->setToken($token)->post(
                $url,
                $data
            );
        } elseif ($method == 'get') {
            $response = $data ?  $this->setToken($token)->get(
                $url,
                $data
            ) : $this->setToken($token)->get(
                $url
            );
        }
        if ($response->failed()) {
            throw new \Exception($response->throw());
        }
        $jsonData = $response->json();

        return isset($jsonData['data']) ? $jsonData['data'] : $jsonData;
    }
}
