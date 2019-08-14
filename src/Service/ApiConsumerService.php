<?php


namespace App\Service;

use GuzzleHttp\Client;
use JMS\Serializer\Serializer;

/**
 * Class ApiConsumerService
 * @package App\Service
 */
class ApiConsumerService
{
    /**
     * @var Client
     */
    protected $httpClient;
    /**
     * @var Serializer
     */
    protected $serializer;
    /**
     * @var string
     */
    protected $class;

    /**
     * ApiConsumerService constructor.
     * @param Client $httpClient
     * @param Serializer $serializer
     * @param string $class
     */
    public function __construct(Client $httpClient, Serializer $serializer, string $class)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
        $this->class = $class;
    }

}