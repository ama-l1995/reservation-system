@extends('layouts.app')

@section('title', ' - Add Service')

@section('content')
    <h1 class="mb-4">Add New Service</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price (EGP)</label>
                    <input type="number" name="price" id="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_available" class="form-label">Available</label>
                    <select name="is_available" id="is_available" class="form-control" required>
                        <option value="1" {{ old('is_available', 1) == 1 ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ old('is_available', 1) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                    @error('is_available')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Service</button>
            </form>
        </div>
    </div>
@endsection
