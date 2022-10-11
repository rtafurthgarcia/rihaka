<?php  

namespace App\Core;

class ConverterHelper {
    public static function convertUMLtoASCIInema($filePath): string {
        $newFilePath = $filePath . '.' . 'cast';
        $returnValue = (int)shell_exec("python3 ../app/Core/asciinema.py -c -o {$newFilePath} {$filePath}; echo $?");
        if ($returnValue > 0) {
            throw new \ErrorException("Conversion: UML file conversion failed. Try again?");
        }

        return $newFilePath;
    }

    public static function secondsToTime(int $seconds): string {
        $minutes = intval($seconds / 60);
        return str_pad($minutes, 1, '0', STR_PAD_LEFT) . ':' . str_pad(($seconds % 60), 2, '0', STR_PAD_LEFT);
    }

    public static function timeToSeconds(string $time): int {
        $array = explode(':', $time);
        if (count($array) === 3) {
            return $array[0] * 3600 + $array[1] * 60 + $array[2];
        }
        return $array[0] * 60 + $array[1];
    }
}