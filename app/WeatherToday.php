<?php

namespace App;

class WeatherToday
{
    private string $hour;
    private string $icon;
    private float $tempC;

    public function __construct(string $hour, string $icon, float $tempC)
    {
        $this->hour = $hour;
        $this->icon = $icon;
        $this->tempC = $tempC;
    }

    public function getHour(): string
    {
        return $this->hour;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getTempC(): float
    {
        return $this->tempC;
    }

}