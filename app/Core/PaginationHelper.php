<?php  

namespace App\Core;

/* https://www.php.net/manual/en/function.session-create-id.php */

class PaginationHelper {
    static function getRangeOfPages(int $currentPage, int $numberOfElements, int $maxElementPerPage, int $rangeSize): array {
        $farthestPage = ceil($numberOfElements / $maxElementPerPage);

        $lowerPage = $currentPage - 1;
        if ($currentPage === $farthestPage) {
            $lowerPage = $currentPage - 2;
        } 
        if ($lowerPage <= 0) {
            $lowerPage = 1;
        }

        $upperPage = $lowerPage + $rangeSize;
        if ($upperPage > $farthestPage) {
            $upperPage = $farthestPage;
        } 

        return range($lowerPage, $upperPage);
    }
}