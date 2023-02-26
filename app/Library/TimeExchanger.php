<?php

namespace App\Library;

class TimeExchanger {

    public static function convertSecToHMS($seconds) {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;
        $hms = sprintf("%02dh%02dm%02ds", $hours, $minutes, $seconds);
        return $hms;
    }
}