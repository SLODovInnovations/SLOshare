<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;

class UserUploaded25Subtitles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'UporabnikNalozil25Podnapisov';

    /*
     * A small description for the achievement
     */
    public $description = 'Naložili ste 25 podnapisov!';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 25;
}
