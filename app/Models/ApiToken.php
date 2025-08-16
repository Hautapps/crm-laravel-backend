<?php

namespace App\Models;

use Illuminate\Support\Str;    
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = ['user_id', 'token', 'expires_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a new token for a user and return the plain token.
     */
    public static function generateTokenForUser($user)
    {
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        self::create([
            'user_id' => $user->id,
            'token' => $hashedToken,
            'expires_at' => now()->addDays(30),
        ]);

        return $plainToken; // Return only the plain version once
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
