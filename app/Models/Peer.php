<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Exception;

class Peer extends Model
{
    use HasFactory;

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Belongs To A User.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Belongs To A Torrent.
     */
    public function torrent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Torrent::class);
    }

    /**
     * Belongs To A Seed.
     */
    public function seed(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Torrent::class, 'torrents.id', 'torrent_id');
    }

    /**
     * Updates Connectable State If Needed.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws Exception
     *
     * @var resource
     */
    public function updateConnectableStateIfNeeded(): void
    {
        if (config('announce.connectable_check')) {
            $tmp_ip = inet_ntop(pack('A'.\strlen($this->ip), $this->ip));
            // IPv6 Check
            if (filter_var($tmp_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $tmp_ip = '['.$tmp_ip.']';
            }

            $key = config('cache.prefix').':peers:connectable:'.$tmp_ip.'-'.$this->port.'-'.$this->agent;
            $cache = Redis::connection('cache')->get($key);
            $ttl = 0;
            if (isset($cache)) {
                $ttl = Redis::connection('cache')->command('TTL', [$key]);
            }
            if ($ttl < config('announce.connectable_check_interval')) {
                $con = @fsockopen($tmp_ip, $this->port, $_, $_, 1);
                $this->connectable = (int) \is_resource($con);
                Redis::connection('cache')->set($key, serialize($this->connectable));
                Redis::connection('cache')->expire($key, config('announce.connectable_check_interval') + 3600);
                if (\is_resource($con)) {
                    fclose($con);
                }
            }
        }
    }
}
