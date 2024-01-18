<?php
namespace App\Services;
class DateTimeService {

    public static function tweetAge($created_at)
    {
        $datetime1 = new \DateTime();
        $datetime2 = new \DateTime($created_at);
        $diff = (array) $datetime1->diff($datetime2);
        for($i = 0; $i< count($diff); $i++)
        {
            $diffFirstValue = $diff[array_keys($diff)[$i]];
            if($diffFirstValue != 0){
                return $diffFirstValue . array_keys($diff)[$i];
            };
        }
    }
}