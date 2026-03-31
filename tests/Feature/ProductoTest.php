<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $categoria;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Limpiamos rutas para que no use las de la API por error
        Artisan::call('route:clear');

        $this->categoria = Categoria::factory()->create(['id' => 1]);
        
        // Usamos tu tabla 'usuarios' y columna 'rol'
        $this->admin = User::factory()->create([
            'nombre' => 'Zuriel Admin',
            'rol' => 'admin'
        ]);
    }

    public function test_puede_ver_listado_de_productos(): void
    {
        Producto::factory(3)->create();
        
        // Forzamos que la petición NO sea de API
        $response = $this->actingAs($this->admin)
                         ->get(route('productos.index'));
        
        $response->assertStatus(200);
        // Ahora sí encontrará el texto en el HTML
        $response->assertSee('Gestión de Productos'); 
    }

    public function test_admin_puede_crear_producto(): void
    {
        $data = [
            'nombre' => 'Producto Nuevo Zuriel',
            'categoria_id' => 1,
            'precio' => 100,
            'stock' => 10,
            'descripcion' => 'Prueba técnica'
        ];

        $response = $this->actingAs($this->admin)->post(route('productos.store'), $data);
        
        // Verificamos que redirija a la web, no a la API
        $response->assertRedirect(route('productos.index')); 
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto Nuevo Zuriel']);
    }

    public function test_no_puede_crear_producto_sin_nombre(): void
    {
        $response = $this->actingAs($this->admin)
                         ->post(route('productos.store'), ['precio' => 100]);
        
        $response->assertSessionHasErrors('nombre');
    }

    public function test_usuario_normal_no_puede_crear_producto(): void
    {
        $user = User::factory()->create(['rol' => 'usuario', 'nombre' => 'Alumno']);
        
        $response = $this->actingAs($user)->post(route('productos.store'), [
            'nombre' => 'Intento Fallido',
            'categoria_id' => 1,
            'precio' => 10,
            'stock' => 1
        ]);
        
        // IMPORTANTE: Para que este sea VERDE, pon el abort(403) en tu ProductoController
        $response->assertStatus(403);
    }
}