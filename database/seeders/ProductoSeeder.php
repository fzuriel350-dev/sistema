<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        // Definimos los bloques de productos por su categoría real
        $data = [
            'Electrónica' => [
                ['nombre' => 'Laptop HP Pavilion 15"', 'desc' => 'Procesador i5, 16GB RAM.', 'precio' => 12999],
                ['nombre' => 'Pantalla Samsung 65" 4K', 'desc' => 'UHD con colores vibrantes.', 'precio' => 10499],
                ['nombre' => 'Consola PlayStation 5', 'desc' => 'Incluye control DualSense.', 'precio' => 9899],
                ['nombre' => 'Tablet iPad Air 64GB', 'desc' => 'Pantalla Liquid Retina.', 'precio' => 11500],
                ['nombre' => 'Audífonos Sony Noise Cancelling', 'desc' => 'Cancelación de ruido líder.', 'precio' => 5499],
                ['nombre' => 'Monitor Gamer ASUS 27"', 'desc' => 'Frecuencia de 144Hz.', 'precio' => 4500],
                ['nombre' => 'Impresora Epson EcoTank', 'desc' => 'Sistema de tinta continua.', 'precio' => 3800],
            ],
            'Línea Blanca' => [
                ['nombre' => 'Refrigerador Samsung 22p3', 'desc' => 'Dos puertas con despachador.', 'precio' => 18500],
                ['nombre' => 'Lavadora LG 20kg', 'desc' => 'Tecnología TurboWash.', 'precio' => 14200],
                ['nombre' => 'Estufa Whirlpool 30"', 'desc' => 'Acero inoxidable 6 quemadores.', 'precio' => 9500],
            ],
            'Abarrotes' => [
                ['nombre' => 'Arroz Member\'s Mark 10kg', 'desc' => 'Grano largo de primera.', 'precio' => 250],
                ['nombre' => 'Aceite Vegetal 3 Pack', 'desc' => 'Botellas de 1L ideales.', 'precio' => 180],
                ['nombre' => 'Café Soluble Nescafé 1kg', 'desc' => 'Formato ahorro clásico.', 'precio' => 320],
            ],
            'Cuidado Personal' => [
                ['nombre' => 'Shampoo Pantene 1L', 'desc' => 'Cuidado intensivo brillo.', 'precio' => 120],
                ['nombre' => 'Jabón Dove 12 Barras', 'desc' => 'Humectación profunda piel.', 'precio' => 210],
                ['nombre' => 'Crema Lubriderm 946ml', 'desc' => 'Hidratación diaria recomendada.', 'precio' => 165],
            ],
            'Limpieza' => [
                ['nombre' => 'Detergente Ariel Power 10L', 'desc' => 'Jabón líquido blancos.', 'precio' => 380],
                ['nombre' => 'Suavizante Downy 8L', 'desc' => 'Aroma fresco duradero.', 'precio' => 240],
                ['nombre' => 'Limpia Pisos Fabuloso 10L', 'desc' => 'Aroma lavanda desinfecta.', 'precio' => 190],
            ],
            'Muebles' => [
                ['nombre' => 'Silla Oficina Ergonómica', 'desc' => 'Soporte lumbar ajustable.', 'precio' => 2400],
                ['nombre' => 'Escritorio Gamer con LED', 'desc' => 'Superficie amplia gamer.', 'precio' => 3600],
                ['nombre' => 'Colchón Sealy Matrimonial', 'desc' => 'Sistema confort premium.', 'precio' => 7500],
            ],
            'Deportes' => [
                ['nombre' => 'Gimnasio Casa ProForm', 'desc' => 'Estación completa fuerza.', 'precio' => 12500],
                ['nombre' => 'Bicicleta Montaña R29', 'desc' => 'Cuadro aluminio 21 vel.', 'precio' => 6800],
            ]
        ];

        foreach ($data as $nombreCategoria => $productos) {
            // Buscamos el ID de la categoría por su nombre
            $categoria = Categoria::where('nombre', $nombreCategoria)->first();

            if ($categoria) {
                foreach ($productos as $p) {
                    Producto::create([
                        'nombre' => $p['nombre'],
                        'descripcion' => $p['desc'],
                        'precio' => $p['precio'],
                        'stock' => rand(10, 100),
                        'categoria_id' => $categoria->id, // Aquí ya queda vinculada correctamente
                        'imagen' => null
                    ]);
                }
            }
        }
    }
}