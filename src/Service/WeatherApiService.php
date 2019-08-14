<?php

namespace App\Service;

use App\DTO\WeatherResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class WeatherApiService
 * @package App\Service
 */
class WeatherApiService extends ApiConsumerService
{
    Const APP_ID = "25bc2325f50e7412a2fc0ae3eaa838d6";
    Const LIEUSAINT_LATITUDE = "48.63476";
    Const LIEUSAINT_LONGITUDE = "2.54806";

    /**
     * WeatherApiService constructor.
     * @param Client $client
     * @param Serializer $serializer
     * @param string $class
     */
    public function __construct(Client $client, Serializer $serializer, string $class)
    {
        parent::__construct($client, $serializer, $class);
    }

    public function makeWeatherRequest($lat= self::LIEUSAINT_LATITUDE,
                                       $long= self::LIEUSAINT_LONGITUDE,
                                       $app_id = self::APP_ID){

        $response = $this->httpClient->get('/data/2.5/weather',[
            'query' => ['lat' => $lat, 'lon'=> $long, 'appid'=> $app_id]
        ]);

        return $result = $this->getResult($response);
    }

    public function getResult(Response $response){

        if( $response->getStatusCode() != 200){
            return null;
        }

        /**
         * @return WeatherResponse
         */
        $weatherResponse = $this->serializer->deserialize((string)$response->getBody(),$this->class, 'json');

        return $weatherResponse;
    }
}