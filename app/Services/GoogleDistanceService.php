<?php
namespace App\Services;

class GoogleDistanceService
{
    public function getDistance($origin, $destination)
    {        
        return [
            'distance' => '0 km',  // Teks jarak
            'value' => 0,          // Angka jarak (meter)
        ];
    }
}