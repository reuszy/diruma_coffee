<?php
namespace App\Helpers;

class DistanceHelper
{
    public static function getDistance($origin, $destination)
    {
        // --- BYPASS MODE ---
        // Kita tidak lagi memanggil Google API.
        // Langsung return data "sukses" dengan jarak 0.
        
        return [
            'distance' => '0 miles',       // Teks jarak
            'value_in_miles' => 0,         // Angka jarak (miles)
            'value_in_meters' => 0,        // Angka jarak (meter)
        ];
    }   
}