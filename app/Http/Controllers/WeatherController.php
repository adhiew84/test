<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\ValidationException;
use Validator;

class WeatherController extends BaseController
{
    protected $client_id;
    protected $host;
    function __construct() {
        $this->client_id = config('services.weather.app_id');
        $this->host = config('services.weather.host');
    }
    public function index(){
        $url = $this->host;
        $data = array(
            "q"=>"Jakarta",
            "units"=>"metric",
            "lang"=>"en",
            "mode"=>"json",
            "appid"=>$this->client_id
        );
        $company_name="Weather Company";
        $weather = $this->getWeather($url,$data);
        $new_data=compact("company_name","weather");
        return view("view", $new_data);
    }

    public function weather(Request $request){
        
        $request->validate([
            'location' => 'required|string|max:255',
        ]);
        $url = $this->host;
        $data = array(
            "q"=>$request->location,
            "units"=>"metric",
            "lang"=>"en",
            "mode"=>"json",
            "appid"=>$this->client_id
        );
        $company_name="Weather Company";
        $new_data = $this->getWeather($url,$data);
        
        return response()
            ->json([ 'data' => $new_data]);
    }
    public function getWeather($url,$data){
        
        $response=$this->GetHttp(
            $url,
            $data
        );
        if ($response->failed()) {
            throw new \Exception($response->throw());
        }
        $jsonData = $response->json();
        return $jsonData;
        
    }

    protected function GetHttp($url,$data)
    {
        return Http::get($url,$data);
    }

}
