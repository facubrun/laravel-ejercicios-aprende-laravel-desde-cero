<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_store_contacts()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->makeOne([
            'phone_number' => '123456789',
            'user_id' => $user->id,
        ]); # lo crea en memoria pero no en la db
        
        $response = $this->actingAs($user)->post(route('contacts.store'), $contact->getAttributes());

        $response->assertRedirect(route('home'));
        $response->assertDatabaseCount('contacts', 1);
        $response->assertDatabaseHas('contacts', [
            'phone_number' => '123456789',
            'user_id' => $user->id,
            'email' => $contact->email,
            'name' => $contact->name,
            'age' => $contact->age,
        ]);
    }
}
