<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactShareControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_share_contacts()
    {
        [$user1,$user2] = User::factory(2)->create();
        $contact = Contact::factory()->createOne([
            'user_id' => $user1->id,
            'phone_number' => '123456789',
        ]);

        $response = $this
            ->actingAs($user1)
            ->Post(route('contact-shares.store'), [
                'contact_email' => $contact->email,
                'user_email' => $user2->email,
            ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('contact_shares', [
            'contact_id' => $contact->id,
            'user_id' => $user2->id,
        ]);

        $sharedContact = $user2->sharedContacts()->first();

        $this->assertTrue($contact->is($sharedContact));
    }


    /**
     * @depends test_user_can_share_contacts
     */
    public function test_user_can_see_shared_contact(){
        [$user1,$user2] = User::factory(2)->hasContacts(5)->create();

        $contact = $user1->contacts()->first();
        
        $contact->sharedWithUsers()->attach($user2->id);

        // Verificar que se guardó correctamente
        $this->assertDatabaseHas('contact_shares', [
            'contact_id' => $contact->id,
            'user_id' => $user2->id,
        ]);

        $response = $this->actingAs($user2)
            ->get(route('contact-shares.show', $contact->id));

        $response->assertStatus(200);
    }

    public function test_user_cant_share_already_shared_contact(){
        [$user1,$user2] = User::factory(2)->hasContacts(5)->create();

        $contact = $user1->contacts()->first();
    
        $contact->sharedWithUsers()->attach($user2->id);

        $response = $this->actingAs($user2)
            ->post(route('contact-shares.store', [
                'contact_email' => $contact->email,
                'user_email' => $user2->email,
            ]));

        $response->assertSessionHasErrors('contact_email');
    }
}
