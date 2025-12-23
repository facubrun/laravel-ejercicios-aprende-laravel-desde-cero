<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContactShareController extends Controller
{

    public function index(){
        
        $contactsSharedWithUser = auth()->user()->sharedContacts()->with('user')->get();
        $contactsSharedByUser = auth()
            ->user()
            ->contacts()
            ->with(['sharedWithUsers' => fn($query) => $query->withPivot('id')])
            ->get()
            ->filter(fn($contact) => $contact->sharedWithUsers->isNotEmpty());

        return view('contact-shares.index', compact('contactsSharedWithUser', 'contactsSharedByUser'));
    }

    public function create(){
        return view('contact-shares.create');        
    }

    public function store(Request $request){
        $data = $request->validate([
            'contact_email' => Rule::exists('contacts', 'email')->where('user_id', auth()->id()),
            'user_email' => 'exists:users,email|not_in:{$request->user()->email}',
        ], [
            'user_email.not_in' => "You can't share a contact with yourself",
            'contact_email.exists' => "The contact email does not exist in your contacts list"
        ]);

        $user = User::where('email', $data['user_email'])->first(['id', 'email']);
        $contact = Contact::where('email', $data['contact_email'])->first(['id', 'email']);

        $shareExists = $contact->sharedWithUsers()->where('user_id', $user->id)->exists();

        if($shareExists){
            return back()->withErrors(['contact_email' => "This contact is already shared with {$user->email}"]);
        } else {
            $contact->sharedWithUsers()->attach($user->id); # agrego al usuario en la tabla pivote
        }
        
        return redirect()->route('home')->with('alert', [
            'message' => "Contact {$contact->email} shared with {$user->email} successfully.", 
            'type' => 'success'
        ]);
    }

    public function destroy(int $id){
        $contactShare = DB::selectOne('SELECT * FROM contact_shares WHERE id = ?', [$id]);

        $contact = Contact::findOrFail($contactShare->contact_id);
        abort_if($contact->user_id !== auth()->id(), 403); # solo el dueño del contacto puede dejar de compartirlo

        $contact->sharedWithUsers()->detach($contactShare->user_id); # elimino al usuario de la tabla pivote

        return redirect()->route('contact-shares.index')->with('alert', [
            'message' => "Contact {$contact->email} unshared.", 
            'type' => 'success'
        ]); 
    }
}
