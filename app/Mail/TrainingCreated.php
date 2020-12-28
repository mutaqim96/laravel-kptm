<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Model\Training;

class TrainingCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $training;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Training $training)
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.training-mailable')
                    ->subject('Training Created using Mailable Class');
    }
}
