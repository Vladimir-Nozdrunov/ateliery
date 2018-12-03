<?php

namespace App\Service;

class Haversine
{
    public function calculate($fromLat, $fromLng, $toLat, $toLng)
    {
        $earth_radius = 6371;
        $dLat = deg2rad($toLat - $fromLat);
        $dLon = deg2rad($toLng - $fromLng);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($fromLat)) * cos(deg2rad($toLat)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}