<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReporteListo extends Mailable
{
    use Queueable, SerializesModels;

    public $rutaArchivo;

    public function __construct($rutaArchivo)
    {
        $this->rutaArchivo = $rutaArchivo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Reporte de Productos está listo - UPTex',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporte-listo',
            // ESTA ES LA PARTE IMPORTANTE:
            with: [
                'url' => asset('storage/' . $this->rutaArchivo),
                'fecha' => now()->format('d/m/Y H:i'), 
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}