<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends BaseVerifyEmail
{
    protected function verificationUrl($notifiable)
    {
        $frontendUrl = config('app.frontend_url'); // Get frontend URL from config

        // Build the verification URL with parameters (id and hash)
        $url = $frontendUrl . '/verifyemail?id=' . $notifiable->getKey() . '&hash=' . sha1($notifiable->getEmailForVerification());

        return str_replace(config('app.url'), $frontendUrl, $url);
    }

    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
                    ->subject('Verify Email Address')
                    ->line('Click the button below to verify your email address.')
                    ->action('Verify Email Address', $url)
                    ->line('If you did not create an account, no further action is required.');
    }
}
