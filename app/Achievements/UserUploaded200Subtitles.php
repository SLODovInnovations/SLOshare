<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;

class UserUploaded200Subtitles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'UporabnikNalozil200Podnapisov';

    /*
     * A small description for the achievement
     */
    public $description = 'Naložili ste 200 podnapisov!';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 200;
}
