<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendgridEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $headerData = [
            'category' => 'category',
            'unique_args' => ['variable_1' => 'abc']
        ];
        $header = $this->asString($headerData);

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()->addTextHeader('X-SMTPAPI', $header);
        });

        return $this->view($this->data['view'])
                    ->from($this->data['address'], $this->data['name'])
                    ->cc($this->data['address'], $this->data['name'])
                    ->bcc($this->data['address'], $this->data['name'])
                    ->replyTo($this->data['address'], $this->data['name'])
                    ->subject($this->data['subject'])
                    ->with([ 'data' => $this->data ]);
    }

    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);
        return $json;
    }


    private function asString($data)
    {
        $json = $this->asJSON($data);
        return wordwrap($json, 76, "\n   ");
    }
}