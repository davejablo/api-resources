<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewTaskNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $name;
    private $taskName;
    private $projectName;
    private $expr;

    public function __construct($name, $taskName, $projectName, $expr)
    {
        $this->name = $name;
        $this->taskName = $taskName;
        $this->projectName = $projectName;
        $this->expr = $expr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('health.clinic.pro@gmail.com', 'Taskager')
            ->subject('Taskager Task Notification')
            ->markdown('emails.task-email', [
                'name' => $this->name,
                'taskName' => $this->taskName,
                'projectName' => $this->projectName,
                'expr' => $this->expr
            ]);
    }
}
