<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public $table = 'cast';

    public function tv(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tv::class, 'cast_tv', 'tv_id', 'cast_id');
    }

    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'cast_season', 'season_id', 'cast_id');
    }

    public function episode(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Episode::class, 'cast_episode', 'episode_id', 'cast_id');
    }

    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'cast_movie', 'movie_id', 'cast_id');
    }

    public function cartoons(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Cartoons::class, 'cast_cartoons', 'cartoons_id', 'cast_id');
    }
}
