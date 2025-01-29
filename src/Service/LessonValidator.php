<?php
namespace App\Service;

use App\Entity\Session;

class LessonValidator
{
    public function validateLessons(Session $session, array $programs): bool
    {
        
        // VERIFY DUPLICATES && DURATION
        // create needed variables
        $lessons = [];
        $totalDuration = 0;
        // get max duration
        $maxDuration = $session->getWorkingDays();
        foreach ($programs as $program) {

            // DUPLICATES
            // get lesson id
            $lessonId = $program->getLesson()->getId();
            // check if lesson id is in array
            if (in_array($lessonId, $lessons)) {
                // if it is, duplicate entry, return false
                return false;
            }
            // if not, put the id in the array
            $lessons[] = $lessonId;

            // DURATION
            // get lesson duration
            $lessonDuration = $program->getDuration();
            // add to totalDuration  
            $totalDuration += $lessonDuration;          
            if ($totalDuration > $maxDuration) {
                // if the total duration is superior to max, return false
                return false;
            }
        }
        // Loop ^


        return true;
    }
}