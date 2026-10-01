<?php

namespace App\Notifications;

use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PatientReading extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($patient_data)
    {
        $this->model = $patient_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $patient = Patient::findOrFail($this->model->patient_id);
        $sys = $this->model->data['sys'];
        $dia = $this->model->data['dia'];
        $bp = "{$sys}/{$dia}";
        $title = "{$patient->first_name} {$patient->last_name} ({$bp})";
        $url = route('patient.show', ['patient', $patient, 'type' => 'rpm']);
        $icon = "fas fa-user";
        $color = get_category($sys, $dia);
        $msg = "The Patient reading has been taken!";
        return [
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'color' => $color,
            'msg' => $msg,
        ];
    }
}
