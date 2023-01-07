<?php

namespace App\Models;

use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    use Auditable;

    /**
     * The Attributes That Are Mass Assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'multiple_choice',
    ];

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
     * A Poll Has Many Options.
     */
    public function options(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * A Poll Has Many Voters.
     */
    public function voters(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Voter::class);
    }

    /**
     * Set The Poll's Title.
     */
    public function setTitleAttribute($title): void
    {
        $this->attributes['title'] = $title;
    }

    /**
     * Get Total Votes On A Poll Option.
     */
    public function totalVotes(): int
    {
        $result = 0;
        foreach ($this->options as $option) {
            $result += $option->votes;
        }

        return $result;
    }
}
