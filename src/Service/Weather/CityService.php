<?php


namespace App\Service\Weather;

/**
 * Class CityService
 */
class CityService
{
    /**
     * Format received /weather?q=xx data.
     *
     * @param array $data API data
     * @return array
     */
    public static function format($data)
    {
        $deg = array_key_exists('deg', $data['wind']) ? $data['wind']['deg'] : 0;
        return [
            'name' => $data['name'] . ' (' . $data['sys']['country'] . ')',
            'icon' => 'images/icons/' . $data['weather'][0]['icon'] . '.png?' . microtime(true),
            'temp' => $data['main']['temp'],
            'pres' => $data['main']['pressure'],
            'wdir' => $deg,
            'wdnm' => self::getWindDirectionName($deg),
            'wvel' => round($data['wind']['speed'] * 3.6),
        ];
    }

    /**
     * Get Wind direction name as string.
     *
     * @param $deg
     * @return string $name
     */
    private static function getWindDirectionName($deg)
    {
        //src: http://snowfence.umn.edu/Components/winddirectionanddegreeswithouttable3.htm
        if ($deg >= 348.75 || $deg < 11.25) {
            $name = 'N';
        } elseif ($deg >= 11.25 && $deg < 33.75) {
            $name = 'NNE';
        } elseif ($deg >= 33.75 && $deg < 56.25) {
            $name = 'NE';
        } elseif ($deg >= 56.25 && $deg < 78.75) {
            $name = 'ENE';
        } elseif ($deg >= 78.75 && $deg < 101.25) {
            $name = 'E';
        } elseif ($deg >= 101.25 && $deg < 123.75) {
            $name = 'ESE';
        } elseif ($deg >= 123.75 && $deg < 146.25) {
            $name = 'SE';
        } elseif ($deg >= 146.25 && $deg < 168.75) {
            $name = 'SSE';
        } elseif ($deg > 168.75 && $deg < 191.25) {
            $name = 'S';
        } elseif ($deg >= 191.25 && $deg < 213.75) {
            $name = 'SSW';
        } elseif ($deg >= 213.75 && $deg < 236.25) {
            $name = 'SW';
        } elseif ($deg >= 236.25 && $deg < 258.75) {
            $name = 'WSW';
        } elseif ($deg >= 258.75 && $deg < 281.25) {
            $name = 'W';
        } elseif ($deg >= 281.25 && $deg < 303.75) {
            $name = 'WNW';
        } elseif ($deg >= 303.75 && $deg < 326.25) {
            $name = 'NW';
        } elseif ($deg >= 326.25 && $deg < 348.75) {
            $name = 'NNW';
        } else {
            $name = 'Nicht verfügbar';

        }
        return $name . ' (' . $deg . '°)';
    }
}
