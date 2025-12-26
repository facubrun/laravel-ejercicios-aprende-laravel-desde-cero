<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_store_products()
    {
        $user = User::factory()->create();

        $productData = [
            'name' => 'Product test',
            'description' => 'test description',
            'price' => 99.99,
        ];
        
        $response = $this->actingAs($user)->post(route('products.store'), $productData);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Product created successfully',
        ]);
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => 'Product test',
            'description' => 'test description',
            'price' => 99.99,
            'user_id' => $user->id,
        ]);
    }

    public function test_store_product_validation()
    {
        $user = User::factory()->create();

        $invalidData = [
            'description' => null,
            'name' => null,
            'price' => -5,
        ];
        
        $response = $this->actingAs($user)->post(route('products.store'), $invalidData);

        $response->assertSessionHasErrors(['description', 'name', 'price']);
        $this->assertDatabaseCount('products', 0);
    }

    /**
     * @depends test_user_can_store_products
     */
    public function test_only_owner_can_update_or_delete_product()
    {
        [$owner,$notOwner] = User::factory(2)->create();
        $product = Product::factory()->createOne([
            'user_id' => $owner->id,
            'name' => 'Product test',
        ]);

        // Test update - must send valid data for validation to pass
        $response = $this->actingAs($notOwner)
            ->put(route('products.update', $product->id), [
                'name' => 'Updated name',
                'description' => 'Updated description',
                'price' => 69.99,
            ]);
            
        $response->assertStatus(403); // Forbidden porque no es el dueño
        

        $response = $this->actingAs($notOwner)
            ->delete(route('products.destroy', $product->id));
            
        $response->assertStatus(403); // Forbidden porque no es el dueño
    }       
}