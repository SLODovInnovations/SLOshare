<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordSecurity extends Model
{

    protected $guarded = [];

    protected $casts = [
        'recovery' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}