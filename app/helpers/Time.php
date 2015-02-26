<?php

class Time{

    /**
     * Returns formatted date from unix timestamp
     * @param int $time
     * @param bool $showHoursAndMins
     * @return string
     */
    public function humanize($time = 0, $showHoursAndMins = false){
        try{
            if(empty($time)) throw new \Exception;

            $date = date('d.m.Y', $time);

            if(!empty($showHoursAndMins))$date .= ' '.date('H:i', $time);

            return $date;
        }catch (\Exception $e){
            return '';
        }
    }
}