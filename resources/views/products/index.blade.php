@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Products</h2>
      <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Product
      </a>
    </div>
    
    @forelse ($products as $product)
      <div class="d-flex justify-content-between bg-dark mb-3 rounded px-4 py-2 align-items-center">
        <div class="d-flex align-items-center">
          <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-white me-3">
            <i class="bi bi-box-seam" style="font-size: 1.5rem;"></i>
          </a>
          <div>
            <p class="mb-0 fw-bold">{{ $product->name }}</p>
            <small class="text-muted d-none d-md-block">{{ $product->description }}</small>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2">
          <p class="mb-0 fw-bold text-success me-3">${{ number_format($product->price, 2) }}</p>
          <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil"></i>
          </a>
          <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
              <i class="bi bi-trash"></i>
            </button>
          </form>
        </div>
        
      </div>
    @empty
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p class="mt-3">No products saved yet</p>
          <a href="{{ route('products.create') }}" class="btn btn-primary">Add One!</a>
        </div>
      </div>
    @endforelse
  </div>
@endsection
