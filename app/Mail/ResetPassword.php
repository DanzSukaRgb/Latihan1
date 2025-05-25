<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, string $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject('Reset Password Anda')
            ->view('emails.reset-password');
    }
}