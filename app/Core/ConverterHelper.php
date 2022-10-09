<?php  

namespace App\Core;

class ConverterHelper {
    public static function convertUMLtoASCIInema($filePath): string {
        $newFilePath = $filePath . '.' . 'cast';
        $returnValue = (int)shell_exec("python3 ../app/Core/asciinema.py -c -o {$newFilePath} {$filePath} && echo $?");

        return $newFilePath;
    }
}