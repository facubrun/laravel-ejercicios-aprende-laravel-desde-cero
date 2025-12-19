@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Edit Product</div>

          <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product->id) }}">
              @csrf
              @method('PUT')
              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $product->name }}"
                    autocomplete="name" autofocus>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="price"
                  class="col-md-4 col-form-label text-md-end">Description</label>

                <div class="col-md-6">
                  <input id="description" type="tel" class="form-control @error('description') is-invalid @enderror"
                    name="description" value="{{ old('description') ?? $product->description }}" autocomplete="description">
                    @error('description')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="price"
                  class="col-md-4 col-form-label text-md-end">price</label>

                <div class="col-md-6">
                  <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    name="price" value="{{ old('price') ?? $product->price }}" autocomplete="price">
                    @error('price')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection