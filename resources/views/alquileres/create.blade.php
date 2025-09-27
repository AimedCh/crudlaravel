@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Rental Property</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.alquileres.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Property Title *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City *</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                           id="city" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                   id="address" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price per Night *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" 
                                               class="form-control @error('price_per_night') is-invalid @enderror" 
                                               id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}" required>
                                    </div>
                                    @error('price_per_night')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="max_guests" class="form-label">Max Guests *</label>
                                    <input type="number" min="1" 
                                           class="form-control @error('max_guests') is-invalid @enderror" 
                                           id="max_guests" name="max_guests" value="{{ old('max_guests') }}" required>
                                    @error('max_guests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bedrooms" class="form-label">Bedrooms *</label>
                                    <input type="number" min="0" 
                                           class="form-control @error('bedrooms') is-invalid @enderror" 
                                           id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" required>
                                    @error('bedrooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="bathrooms" class="form-label">Bathrooms *</label>
                                    <input type="number" min="0" 
                                           class="form-control @error('bathrooms') is-invalid @enderror" 
                                           id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" required>
                                    @error('bathrooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="distance_to_beach" class="form-label">Distance to Beach (km)</label>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('distance_to_beach') is-invalid @enderror" 
                                           id="distance_to_beach" name="distance_to_beach" value="{{ old('distance_to_beach') }}">
                                    @error('distance_to_beach')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="number" step="0.1" min="0" max="5" 
                                           class="form-control @error('rating') is-invalid @enderror" 
                                           id="rating" name="rating" value="{{ old('rating', 0) }}">
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" step="0.00000001" 
                                           class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" name="latitude" value="{{ old('latitude') }}">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" step="0.00000001" 
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" name="longitude" value="{{ old('longitude') }}">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Property Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amenities</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="WiFi" 
                                               id="amenity1" {{ in_array('WiFi', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity1">WiFi</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Air Conditioning" 
                                               id="amenity2" {{ in_array('Air Conditioning', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity2">Air Conditioning</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Kitchen" 
                                               id="amenity3" {{ in_array('Kitchen', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity3">Kitchen</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Parking" 
                                               id="amenity4" {{ in_array('Parking', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity4">Parking</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Pool" 
                                               id="amenity5" {{ in_array('Pool', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity5">Pool</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Beach Access" 
                                               id="amenity6" {{ in_array('Beach Access', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity6">Beach Access</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="Balcony" 
                                               id="amenity7" {{ in_array('Balcony', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity7">Balcony</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amenities[]" value="TV" 
                                               id="amenity8" {{ in_array('TV', old('amenities', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="amenity8">TV</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                           id="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Property is listed)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="available" value="1" 
                                           id="available" {{ old('available') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="available">
                                        Available for booking
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.alquileres.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Rental
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
