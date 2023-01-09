<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistClient extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
