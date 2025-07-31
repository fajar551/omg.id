<?php

namespace App\Src\Base;

use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    public function getFormatedType()
    {
        $type = $this->type;
        
        switch ($type) {
            case 'App\Notifications\ResetPasswordNotification':
                $type = 'notify.password_reset';
                break;
            case 'App\Notifications\WelcomeEmailNotification':
                $type = 'notify.new_user_registered';
                break;
            case 'App\Notifications\NewTipNotification':
                $type = 'notify.new_tip';
                break;
            default:
                break;
        }

        return $type;
    }

    public function getNotificationsMessage($type = null)
    {
        $type = $type ?? $this->type;
        $message = "-";
        
        switch ($type) {
            case 'App\Notifications\ResetPasswordNotification':
                $message = __('Permintaan untuk atur ulang kata sandi telah dikirim ke alamat email.');
                break;
            case 'App\Notifications\WelcomeEmailNotification':
                $message = __('Selamat datang di omg.id, akun-mu telah berhasil diverifikasi.');
                break;
            case 'App\Notifications\NewTipNotification':
                $message = $this->data['new_tip']['template_text'];
                break;
            default:
                break;
        }

        return $message;
    }
}
