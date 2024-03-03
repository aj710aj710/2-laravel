<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailNotify extends Mailable
{
    use Queueable, SerializesModels;

    protected $singleData;
    protected $userData;
    protected $customData;
    protected $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($singleData=null,$userData=null,$customData=null,$template=null)
    {
        $this->singleData = $singleData;
        $this->userData = $userData;
        $this->customData = $customData;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->singleData != null)
        {
            return $this->from(getOption('MAIL_FROM_ADDRESS'), getOption('app_name'))
            ->subject($this->singleData->subject)
            ->markdown('mail.single-email-notify')
            ->with([
                'message' => $this->singleData->message,
            ]);
        }
        else{
            return $this->from(getOption('MAIL_FROM_ADDRESS'), getOption('app_name'))
            ->subject(getEmailTemplate($this->template, 'subject', $link = '', $this->customData, $this->userData))
            ->markdown('mail.email-notify')
            ->with([
                'customData' => $this->customData,
                'userData' => $this->userData,
                'template' => $this->template,
            ]);
        }
    }
}
