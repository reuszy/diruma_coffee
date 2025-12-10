<?php
namespace App\Services;

class GoogleDistanceService
{
    public function getDistance($origin, $destination)
    {
        // --- BYPASS MODE ---
        // Langsung return data "sukses" dengan jarak 0.
        
        return [
            'distance' => '0 km',  // Teks jarak
            'value' => 0,          // Angka jarak (meter)
        ];
    }
}