<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;

class UserUploaded1000Subtitles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'UporabnikNalozil1000Podnapisov';

    /*
     * A small description for the achievement
     */
    public $description = 'Naložili ste 1000 podnapisov!';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 1_000;
}
