<?php

if (! function_exists('convertLongToTimeChar'))
{

    function convertLongToTimeChar($usedTime)
    {
        $day="";
        $hour="";
        $min="";
        $sec="";

        $d = floor($usedTime/1000/60/60/24);
        if ($d!=0)
            $day = $d."d ";

        $h = floor(($usedTime/1000/60/60));
        if ($h!=0)
            $hour = $h."h ";

        $m = floor(($usedTime/1000/60) % 60);
        if ($m!=0)
            $min = $m."m ";

        $s = floor(($usedTime/1000) % 60);
        if ($s==0 && ($h!=0 || $m!=0))
            $sec="";
        else
            $sec = $s."s";

        return $day.$hour.$min.$sec;
    }
}

if (! function_exists('getUserAge')) {
    function getUserAge($date) {
        return \Carbon\Carbon::parse($date)->diff(\Illuminate\Support\Carbon::now())->format('%y');
    }
}
