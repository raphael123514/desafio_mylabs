<?php

namespace App\Mail;

use App\Models\Checkin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelarAula extends Mailable
{
    use Queueable, SerializesModels;

    protected $checkin;

    public function __construct(Checkin $checkin)
    {
        $this->checkin = $checkin;    
    }

    public function build()
    {

        return $this->view('mails.cancelarAula')->with([
            'nome' => $this->checkin->nome,
            'professor' => $this->checkin->nome_prof,
            'data_hora' => date("d/m/Y G:i",strtotime($this->checkin->data_hora)),
        ]);
    }
}
