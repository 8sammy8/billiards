<?php

if (! function_exists('HI_time')) {
    /**
     * Returns an array of 24 hours in 00:00 format
     *
     * @return array
     */
    function HI_time()
    {
        $array = [];
        foreach (range(0, 23, 1) as $item){
            $array[] = ($item < 10 ? '0' . $item : $item) . ':00';
        }
        return $array;
    }
}
