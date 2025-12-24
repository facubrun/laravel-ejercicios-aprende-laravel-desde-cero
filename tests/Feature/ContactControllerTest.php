<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'phone_number' => '123456789',
            'user_id' => $user->id,
            'email' => $contact->email,
            'name' => $contact->name,
            'age' => $contact->age,
        ]);
    }

    public function test_store_contact_validation()
    {
        $user = User::factory()->create();

        $invalidData = [
            'phone_number' => 'Wrong phone number',
            'email' => "Wrong email",
            'name' => null,
            'age' => -5,
        ];
        
        $response = $this->actingAs($user)->post(route('contacts.store'), $invalidData);

        $response->assertSessionHasErrors(['phone_number', 'name', 'age']);
        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * @depends test_user_can_store_contacts
     */
    public function test_only_owner_can_update_or_delete_contact()
    {
        [$owner,$notOwner] = User::factory(2)->create();
        $contact = Contact::factory()->createOne([
            'user_id' => $owner->id,
            'phone_number' => '123456789',
        ]);

        // Test update - must send valid data for validation to pass
        $response = $this->actingAs($notOwner)
            ->put(route('contacts.update', $contact->id), [
                'name' => 'Updated Name',
                'phone_number' => '123456789',
                'age' => 25,
                'email' => 'updated@example.com',
            ]);
            
        $response->assertStatus(403); // Forbidden porque no es el dueño
        

        $response = $this->actingAs($notOwner)
            ->delete(route('contacts.destroy', $contact->id));
            
        $response->assertStatus(403); // Forbidden porque no es el dueño
    }       
}