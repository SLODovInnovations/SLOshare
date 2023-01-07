<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    private $types;

    public function __construct()
    {
        $this->types = $this->getTypes();
    }

    /**
     * Auto generated seed file.
     */
    public function run(): void
    {
        foreach ($this->types as $type) {
            Type::updateOrCreate($type);
        }
    }

    private function getTypes(): array
    {
        return [
            [
                'id'       => 1,
                'name'     => 'Xvid',
                'position' => 0,
            ],
            [
                'id'       => 2,
                'name'     => 'BluRay DISC',
                'position' => 1,
            ],
            [
                'id'       => 3,
                'name'     => 'WebRip',
                'position' => 2,
            ],
            [
                'id'       => 4,
                'name'     => 'BluRay',
                'position' => 3,
            ],
            [
                'id'       => 5,
                'name'     => 'DVD-R',
                'position' => 4,
            ],
            [
                'id'       => 6,
                'name'     => 'TvRip',
                'position' => 5,
            ],
            [
                'id'       => 7,
                'name'     => 'Celotni Album',
                'position' => 6,
            ],
            [
                'id'       => 8,
                'name'     => 'Remix',
                'position' => 7,
            ],
            [
                'id'       => 9,
                'name'     => 'FLAC/WAV',
                'position' => 8,
            ],
            [
                'id'       => 10,
                'name'     => 'MP3',
                'position' => 9,
            ],
            [
                'id'       => 11,
                'name'     => 'Mac',
                'position' => 10,
            ],
            [
                'id'       => 12,
                'name'     => 'UNIX',
                'position' => 11,
            ],
            [
                'id'       => 13,
                'name'     => 'Windows Rip',
                'position' => 12,
            ],
            [
                'id'       => 14,
                'name'     => 'Windows',
                'position' => 13,
            ],
            [
                'id'       => 15,
                'name'     => 'Windows ISO',
                'position' => 14,
            ],
            [
                'id'       => 16,
                'name'     => 'iOS',
                'position' => 15,
            ],
            [
                'id'       => 17,
                'name'     => 'Android',
                'position' => 16,
            ],
            [
                'id'       => 18,
                'name'     => 'GSM',
                'position' => 17,
            ],
            [
                'id'       => 19,
                'name'     => 'Nitendo DS',
                'position' => 18,
            ],
            [
                'id'       => 20,
                'name'     => 'Nitendo WII',
                'position' => 19,
            ],
            [
                'id'       => 21,
                'name'     => 'Playstation',
                'position' => 20,
            ],
            [
                'id'       => 22,
                'name'     => 'PSP',
                'position' => 21,
            ],
            [
                'id'       => 23,
                'name'     => 'Xbox',
                'position' => 22,
            ],
            [
                'id'       => 24,
                'name'     => 'Drugo',
                'position' => 23,
            ],
        ];
    }
}
