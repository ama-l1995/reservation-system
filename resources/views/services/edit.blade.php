@extends('layouts.app')

@section('title', ' - Edit Service')

@section('content')
    <h1 class="mb-4">Edit Service</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $service->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (EGP)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price', $service->price) }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_available" class="form-label">Available</label>
                    <select name="is_available" id="is_available" class="form-control" required>
                        <option value="1" {{ old('is_available', $service->is_available) ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('is_available', $service->is_available) ? '' : 'selected' }}>No</option>
                    </select>
                    @error('is_available')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Update Service</button>
            </form>
        </div>
    </div>
@endsection
