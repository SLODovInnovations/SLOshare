<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    private $groups;

    public function __construct()
    {
        $this->groups = $this->getGroups();
    }

    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        foreach ($this->groups as $group) {
            Group::updateOrCreate($group);
        }
    }

    private function getGroups(): array
    {
        return [
            [
                'name'             => 'Validating',
                'slug'             => 'validating',
                'position'         => 4,
                'color'            => '#95A5A6',
                'icon'             => config('other.font-awesome').' fa-question-circle',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'autogroup'        => 0,
                'level'            => 0,
            ],
            [
                'name'             => 'Banned',
                'slug'             => 'banned',
                'position'         => 1,
                'color'            => '#FF0000',
                'icon'             => config('other.font-awesome').' fa-ban',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'autogroup'        => 0,
                'level'            => 0,
            ],
            [
                'name'             => 'Disabled',
                'slug'             => 'disabled',
                'position'         => 2,
                'color'            => '#8D6262',
                'icon'             => config('other.font-awesome').' fa-pause-circle',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'autogroup'        => 0,
                'level'            => 0,
            ],
            [
                'name'             => 'Pijavka',
                'slug'             => 'pijavka',
                'position'         => 5,
                'color'            => '#96281B',
                'icon'             => config('other.font-awesome').' fa-times',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'autogroup'        => 1,
                'level'            => 20,
            ],
            [
                'name'             => 'User',
                'slug'             => 'user',
                'position'         => 6,
                'color'            => '#7289DA',
                'icon'             => config('other.font-awesome').' fa-user',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'autogroup'        => 1,
                'level'            => 30,
            ],
            [
                'name'             => 'PowerUser',
                'slug'             => 'poweruser',
                'position'         => 7,
                'color'            => '#3C78D8',
                'icon'             => config('other.font-awesome').' fa-user-circle',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'can_upload'       => 0,
                'autogroup'        => 1,
                'level'            => 40,
            ],
            [
                'name'             => 'ExtremeUser',
                'slug'             => 'extremeuser',
                'position'         => 9,
                'color'            => '#1c4587',
                'icon'             => config('other.font-awesome').' fa-bolt',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 0,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 0,
                'can_upload'       => 0,
                'autogroup'        => 1,
                'level'            => 60,
            ],
            [
                'name'             => 'VIP',
                'slug'             => 'vip',
                'position'         => 8,
                'color'            => '#BF55EC',
                'icon'             => config('other.font-awesome').' fa-shield',
                'effect'           => 'url(/img/sparkels.gif)',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 100,
            ],
            [
                'name'             => 'Uploader',
                'slug'             => 'uploader',
                'position'         => 9,
                'color'            => '#2ECC71',
                'icon'             => config('other.font-awesome').' fa-upload',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 250,
            ],
            [
                'name'             => 'Moderator',
                'slug'             => 'moderator',
                'position'         => 10,
                'color'            => '#4ECDC4',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'is_internal'      => 0,
                'is_modo'          => 0,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 0,
                'is_immune'        => 0,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 2500,
            ],
            [
                'name'             => 'Administrator',
                'slug'             => 'administrator',
                'position'         => 18,
                'color'            => '#f92672',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'effect'           => 'url(/img/sparkels.gif)',
                'is_internal'      => 0,
                'is_modo'          => 1,
                'is_admin'         => 1,
                'is_owner'         => 0,
                'is_trusted'       => 1,
                'is_immune'        => 1,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 5000,
            ],
            [
                'name'             => 'SYSOP',
                'slug'             => 'sysop',
                'position'         => 19,
                'color'            => '#00abff',
                'icon'             => config('other.font-awesome').' fa-user-secret',
                'effect'           => 'url(/img/sparkels.gif)',
                'is_internal'      => 0,
                'is_modo'          => 1,
                'is_admin'         => 1,
                'is_owner'         => 1,
                'is_trusted'       => 1,
                'is_immune'        => 1,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 9999,
            ],
            [
                'name'             => 'Bot',
                'slug'             => 'bot',
                'position'         => 20,
                'color'            => '#f1c40f',
                'icon'             => 'fab fa-android',
                'is_internal'      => 0,
                'is_modo'          => 1,
                'is_admin'         => 0,
                'is_owner'         => 0,
                'is_trusted'       => 1,
                'is_immune'        => 1,
                'is_freeleech'     => 1,
                'is_double_upload' => 0,
                'is_incognito'     => 0,
                'can_upload'       => 1,
                'autogroup'        => 0,
                'level'            => 0,
            ],
            [
                'name'       => 'Pruned',
                'slug'       => 'pruned',
                'position'   => 0,
                'color'      => '#8D6262',
                'icon'       => config('other.font-awesome').' fa-times-circle',
                'can_upload' => 0,
                'level'      => 0,
            ],

        ];
    }
}
