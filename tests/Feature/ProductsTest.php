<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        /**@var User $user*/
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);
    }

    /**
     * @testdox  Test endpoint Listado de los productos
     */
    public function testListProducts()
    {
        Product::factory(3)->create();
        $response = $this->get('api/products');

        $response->assertJson([
            'success' => true,
            'data' => [
                'products' => []
            ]
        ]);

        $data = $response->json('data.products');
        $count = Product::all()->count();
        $this->assertCount($count, $data);
    }

    /**
     * @testdox Test endpoint creacion de los productos
     */
    public function testCreateProducts()
    {
        $product = Product::factory()->make();
        $data = [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
        ];
        $response = $this->post('api/products', $data);
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data' => [
                'message' => 'Producto creado!',
                'product' => [],
            ]
        ]);

        $id = $response->json('data.product.id');
        $product = Product::query()->findOrFail($id);
        $this->assertModelExists($product);

    }

    /**
     * @testdox Test endpoint edición de los productos
     */
    public function testUpdateProducts()
    {
        $product = Product::factory()->create();
        $data = [
            'name' => 'Mi producto',
            'price' => $product->price,
            'description' => $product->description,
        ];

        $response = $this->put("api/products/$product->id", $data);
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data' => [
                'message' => 'Producto actualizado!',
                'product' => [],
            ]
        ]);

        $id = $response->json('data.product.id');
        $product = Product::query()->findOrFail($id);
        $this->assertModelExists($product);
        $this->assertEquals('Mi producto', $product->name);
    }

    /**
     * @testdox Test endpoint eliminación de los productos
     */
    public function testDeleteProducts()
    {
        $product = Product::factory()->create();

        $response = $this->delete("api/products/$product->id");
        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data' => [
                'message' => 'Producto Eliminado!',
            ]
        ]);

        $count = Product::all()->toArray();
        $this->assertCount(0, $count);
    }

}
