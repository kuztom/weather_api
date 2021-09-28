<?php
namespace App;

class WeatherData
{
    private string $city;
    private string $date;
    private string $icon;
    private float $avgTempC;
    private float $minTempC;
    private float $maxTempC;
    private float $windKph;

    public function __construct(
        string $city,
        string $date,
        string $icon,
        float $avgTempC,
        float $minTempC,
        float $maxTempC,
        float $windKph
    )
    {
        $this->city = $city;
        $this->date = $date;
        $this->icon = $icon;
        $this->avgTempC = $avgTempC;
        $this->minTempC = $minTempC;
        $this->maxTempC = $maxTempC;
        $this->windKph = $windKph;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAvgTempC(): float
    {
        return $this->avgTempC;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getMaxTempC(): float
    {
        return $this->maxTempC;
    }

    public function getMinTempC(): float
    {
        return $this->minTempC;
    }

    public function getWindKph(): float
    {
        return $this->windKph;
    }
}