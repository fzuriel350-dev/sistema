<?php

namespace App\Jobs;

use App\Models\Producto;
use App\Mail\ReporteListo;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerarReporteCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3; // Reintentos si falla
    public int $timeout = 120; // Segundos máximos

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $usuario,
        public string $filtro = ''
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 1. Obtener los productos con su categoría
        $query = Producto::with('categoria');
        
        if ($this->filtro) {
            $query->where('nombre', 'LIKE', '%' . $this->filtro . '%');
        }

        $productos = $query->get();

        // 2. Generar el contenido CSV en memoria
        $csv = "ID,Nombre,Categoria,Precio,Stock\n";

        foreach ($productos as $p) {
            $csv .= implode(',', [
                $p->id,
                '"' . $p->nombre . '"',
                $p->categoria->nombre ?? 'General',
                $p->precio,
                $p->stock
            ]) . "\n";
        }

        // 3. Guardar el archivo en el disco público
        $nombreArchivo = 'reportes/productos-' . now()->format('Ymd-His') . '.csv';
        Storage::disk('public')->put($nombreArchivo, $csv);

        // 4. Enviar el correo al usuario que lo solicitó
        Mail::to($this->usuario->email)->send(new ReporteListo($nombreArchivo));
    }
}