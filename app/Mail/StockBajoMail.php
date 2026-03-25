<?php

namespace App\Mail;

// Importante: Importar el modelo Producto
use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StockBajoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * Aquí recibimos el producto para usar sus datos en el correo.
     */
    public function __construct(public Producto $producto)
    {
        // Al poner 'public' en el constructor, Laravel hace que 
        // la variable $producto esté disponible automáticamente en la vista Blade.
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Personalizamos el asunto con el nombre del producto
            subject: 'Alerta: Stock Crítico de ' . $this->producto->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // Indicamos la ruta de la plantilla que creaste en resources/views/emails/
            markdown: 'emails.stock-bajo',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}