<?php


namespace App\Service\Weather;


class CityService
{
    public static function format($data)
    {
        return [
            'name' => $data['name'] . ' (' . $data['sys']['country'] . ')',
            'icon' => '/images/icons/' . $data['weather'][0]['icon'],
            'temp' => $data['main']['temp'],
            'pres' => $data['main']['pressure'],
            'wdir' => $data['wind']['deg'],
            'wdnm' => self::getWindDirectionName($data['wind']['deg']),
            'wvel' => round($data['wind']['speed'] * 3.6),
        ];
    }

    private static function getWindDirectionName($deg)
    {
        //src: http://snowfence.umn.edu/Components/winddirectionanddegreeswithouttable3.htm
        switch ($deg) {
            case $deg > 348.75 || $deg < 11.25:
                $name = 'N';
                break;
            case $deg >= 11.25 && $deg < 33.75:
                $name = 'NNE';
                break;
            case $deg >= 33.75 && $deg < 56.25:
                $name = 'NE';
                break;
            case $deg >= 56.25 && $deg < 78.75:
                $name = 'ENE';
                break;
            case $deg >= 78.75 && $deg < 101.25:
                $name = 'E';
                break;
            case $deg >= 101.25 && $deg < 123.75:
                $name = 'ESE';
                break;
            case $deg >= 123.75 && $deg < 146.25:
                $name = 'SE';
                break;
            case $deg >= 146.25 && $deg < 168.75:
                $name = 'SSE';
                break;
            case $deg > 168.75 && $deg < 191.25:
                $name = 'S';
                break;
            case $deg >= 191.25 && $deg < 213.75:
                $name = 'SSW';
                break;
            case $deg >= 213.75 && $deg < 236.25:
                $name = 'SW';
                break;
            case $deg >= 236.25 && $deg < 258.75:
                $name = 'WSW';
                break;
            case $deg >= 258.75 && $deg < 281.25:
                $name = 'W';
                break;
            case $deg >= 281.25 && $deg < 303.75:
                $name = 'WNW';
                break;
            case $deg >= 303.75 && $deg < 326.25:
                $name = 'NW';
                break;
            case $deg >= 326.25 && $deg < 348.75:
                $name = 'NNW';
                break;
            default:
                $name = 'Nicht verfügbar';
                break;
        }
        return $name;
    }
}
