<?php

namespace App\Jobs\V1\Auth;

use App\Models\User;
use App\Notifications\V1\Auth\VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $email;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::where(['email' => $this->email])->first();
        $otp = $user->createOtp()->otp;

        $user->notify(new VerifyEmailNotification($otp));
    }
}
