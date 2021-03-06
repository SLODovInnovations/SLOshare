<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    use Auditable;

    /**
     * The Attributes That Aren't Mass Assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Belongs To A Request.
     */
    public function request(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TorrentRequest::class, 'request_id');
    }

    /**
     * Belongs To A Torrent.
     */
    public function torrent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Torrent::class, 'torrent_id');
    }

    /**
     * Belongs To A User.
     */
    public function reporter(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter_id')->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Belongs To A User.
     */
    public function reported(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_user')->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }

    /**
     * Belongs To A Staff Member.
     */
    public function staff(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id')->withDefault([
            'username' => 'System',
            'id'       => '1',
        ]);
    }
}
