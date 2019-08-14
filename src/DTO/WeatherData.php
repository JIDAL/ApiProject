<?php


namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class WeatherData
 * @package App\DTO
 * @Serializer\ExclusionPolicy("all")
 */
class WeatherData
{
    /**
     * @var integer
     * @Serializer\Expose()
     * @Serializer\Type("integer")
     */
    public $id;
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $main;
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $description;
    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Type("string")
     */
    public $icon;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMain(): string
    {
        return $this->main;
    }

    /**
     * @param string $main
     */
    public function setMain(string $main): void
    {
        $this->main = $main;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }



}