<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;

class UserUploaded800Subtitles extends Achievement
{
    /*
     * The achievement name
     */
    public $name = 'UporabnikNalozil800Podnapisov';

    /*
     * A small description for the achievement
     */
    public $description = 'Naložili ste 800 podnapisov!';

    /*
     * The amount of "points" this user need to obtain in order to complete this achievement
     */
    public $points = 800;
}
