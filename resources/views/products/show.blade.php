@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Product Information</div>

          <div class="card-body">
            <p>Name: {{ $product->name }}</p>
            <p>Description: {{ $product->description }}</p>
            <p>Price: {{ $product->price }}</p>
            <p>Created at: {{ $product->created_at }}</p>
            <p>Last updated: {{ $product->updated_at }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection