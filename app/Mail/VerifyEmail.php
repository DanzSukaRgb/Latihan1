<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct(User $user)
    {
        $this->user            = $user;
        $this->verificationUrl = route('verify.email', ['token' => $user->email_verification_token]);
    }

    public function build()
    {
        return $this->subject('Verifikasi Email Anda')
            ->view('emails.verify-email')
            ->with([
                'user'            => $this->user,
                'verificationUrl' => $this->verificationUrl,
            ]);
    }
}