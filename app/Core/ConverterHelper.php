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

    function convertSecondsToMinutesSeconds($seconds): string {
        $min = intval($seconds / 60);
        return $min . ':' . str_pad(($seconds % 60), 2, '0', STR_PAD_LEFT);
    }

}