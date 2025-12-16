@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Create Product</div>

          <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}">
              @csrf
              <div class="row mb-3">
                <label for="name"
                  class="col-md-4 col-form-label text-md-end">Name</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    autocomplete="name" autofocus>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="description"
                  class="col-md-4 col-form-label text-md-end"> Description</label>

                <div class="col-md-6">
                  <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    name="description" value="{{ old('description') }}" autocomplete="description">
                    @error('description')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="price"
                  class="col-md-4 col-form-label text-md-end">Price</label>

                <div class="col-md-6">
                  <input id="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    name="price" autocomplete="price">
                    @error('price')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="battery_duration"
                  class="col-md-4 col-form-label text-md-end">Battery Duration</label>

                <div class="col-md-6">
                  <input id="battery_duration" type="number" class="form-control @error('battery_duration') is-invalid @enderror"
                    name="battery_duration" autocomplete="battery_duration">
                    @error('battery_duration')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="colors"
                  class="col-md-4 col-form-label text-md-end">Colors</label>

                <div class="col-md-6">
                  <input id="colors" type="text" class="form-control @error('colors') is-invalid @enderror"
                    name="colors" autocomplete="colors">
                    @error('colors')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="dimensions"
                  class="col-md-4 col-form-label text-md-end">Dimensions</label>

                <div class="col-md-6">
                  <input id="dimensions" type="text" class="form-control @error('dimensions') is-invalid @enderror"
                    name="dimensions" autocomplete="dimensions">
                    @error('dimensions')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="accessories"
                  class="col-md-4 col-form-label text-md-end">Accessories</label>

                <div class="col-md-6">
                  <input id="accessories" type="text" class="form-control @error('accessories') is-invalid @enderror"
                    name="accessories" autocomplete="accessories">
                    @error('accessories')
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