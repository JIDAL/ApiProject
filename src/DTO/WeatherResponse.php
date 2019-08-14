<?php


namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class WeatherResponse
 * @package App\DTO
 * @Serializer\ExclusionPolicy("all")
 */
class WeatherResponse
{
    /**
     * @var array
     * @Serializer\Expose()
     * @Serializer\Type("array<App\DTO\WeatherData>")
     */
    public $weather;
    /**
     * @var integer
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     * @Serializer\SerializedName("cod")
     */
    public $CodeStatus;

    /**
     * @return array
     */
    public function getWeather(): array
    {
        return $this->weather;
    }

    /**
     * @param array $weather
     */
    public function setWeather(array $weather): void
    {
        $this->weather = $weather;
    }

    /**
     * @return int
     */
    public function getCodeStatus(): int
    {
        return $this->CodeStatus;
    }

    /**
     * @param int $CodeStatus
     */
    public function setCodeStatus(int $CodeStatus): void
    {
        $this->CodeStatus = $CodeStatus;
    }


}