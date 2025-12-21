@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <div class="d-flex align-items-center mb-2">
              <img class="profile-picture me-3" src="storage/{{ $contact->profile_picture }}">
              <h3>Contact Information</h3>
            </div>
          </div>

          <div class="card-body">
            <p>Name: {{ $contact->name }}</p>
            <p>Email: <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
            <p>Phone: <a href="tel:{{ $contact->phone_number }}">{{ $contact->phone_number }}</a></p>
            <p>Age: {{ $contact->age }}</p>
            <p>Created at: {{ $contact->created_at }}</p>
            <p>Last updated: {{ $contact->updated_at }}</p>

            <div class="d-flex justify-content-center">
              <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-secondary mb-2 me-2">Edit Contact</a>
              <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mb-2">Delete Contact</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection