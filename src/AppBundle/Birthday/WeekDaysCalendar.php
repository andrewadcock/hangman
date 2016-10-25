<?php

namespace AppBundle\Birthday;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WeekDaysCalendar
{
    
    public function getCalendar($month, $day, $nbYears = 10)
    {
        $weekDays = [];
        $current = (int)date('Y');
    
        for ($year = $current; $year <= $current + $nbYears; $year++) {
        
            $date = checkdate($month, $day, $year);
            // If date doesn't exist
            if (!$date) {
                throw new NotFoundHttpException('Dat aint no birfday');
            }
            $weekDays[$year] = date('l', mktime(0, 0, 0, $month, $day, $year));
        }
        
        return $weekDays;
    }
}