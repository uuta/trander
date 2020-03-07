<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;

class MailResetPasswordNotification extends ResetPassword
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        parent::__construct($token);
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = url(env('URL')."/regenerate-password/" . $this->token);
        return (new MailMessage)
            ->subject('パスワードをリセットする')
            ->line("こんにちは！パスワードを忘れてしまったという連絡をいただきましたので、パスワードのリセット用リンクをお送りします。以下をクリックして新しいパスワードを選択してください。")
            ->action('新しいパスワードを選択する', $link)
            ->line("リンクの有効期限は" . config('auth.passwords.users.expire') . "分です。")
            ->line("もしも誤ってパスワードのリセットをリクエストされた場合は、このメールは無視してください。");
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
