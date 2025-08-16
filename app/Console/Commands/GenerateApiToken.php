<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ApiToken;
use Illuminate\Support\Str;    

class GenerateApiToken extends Command
{
    protected $signature = 'tokens:generate 
        {email? : Email address of the user}
    ';

    protected $description = 'Generate and store a hashed API token for a user, and output the plain token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        if (empty($email)) {
            $this->info("No email provided");
            return;
        }
        $user = User::where('email', $email)->first();
        if (empty($user)) {
            $this->info("User not found");
            return;
        }
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);

        ApiToken::create([
            'user_id' => $user->id,
            'token' => $hashedToken,
            'expires_at' => now()->addYears(1),
        ]);

        $this->info("✅ API token generated for user: {$user->email}");
        $this->line("\n🔑 Plain token (copy now, shown only once):\n");
        $this->line("Bearer {$plainToken}");
    }
}
