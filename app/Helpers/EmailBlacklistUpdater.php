<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class EmailBlacklistUpdater
{
    public static function update(): bool|int
    {
        $url = \config('email-blacklist.source');
        if ($url === null) {
            return false;
        }

        // Define parameters for the cache
        $key = \config('email-blacklist.cache-key');
        $duration = Carbon::now()->addMonth();

        $domains = \json_decode(\file_get_contents($url), true, 512, JSON_THROW_ON_ERROR);
        $count = \is_countable($domains) ? \count($domains) : 0;

        // Retrieve blacklisted domains
        \cache()->put($key, $domains, $duration);

        return $count;
    }
}
