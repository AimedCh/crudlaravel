@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Alquileres (Rentals)</h4>
                    <a href="{{ route('admin.alquileres.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Rental
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($alquileres->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>City</th>
                                        <th>Price/Night</th>
                                        <th>Guests</th>
                                        <th>Bedrooms</th>
                                        <th>Bathrooms</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alquileres as $alquiler)
                                        <tr>
                                            <td>{{ $alquiler->id }}</td>
                                            <td>
                                                @if($alquiler->image)
                                                    <img src="{{ asset('storage/' . $alquiler->image) }}" 
                                                         alt="{{ $alquiler->title }}" 
                                                         class="img-thumbnail" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $alquiler->title }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $alquiler->city }}</span>
                                            </td>
                                            <td>${{ number_format($alquiler->price_per_night, 2) }}</td>
                                            <td>{{ $alquiler->max_guests }}</td>
                                            <td>{{ $alquiler->bedrooms }}</td>
                                            <td>{{ $alquiler->bathrooms }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-warning me-1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star{{ $i <= $alquiler->rating ? '' : '-o' }}"></i>
                                                        @endfor
                                                    </span>
                                                    <small class="text-muted">{{ number_format($alquiler->rating, 1) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <span class="badge {{ $alquiler->is_active ? 'bg-success' : 'bg-secondary' }} mb-1">
                                                        {{ $alquiler->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                    <br>
                                                    <span class="badge {{ $alquiler->available ? 'bg-primary' : 'bg-warning' }}">
                                                        {{ $alquiler->available ? 'Available' : 'Booked' }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.alquileres.show', $alquiler) }}" 
                                                       class="btn btn-sm btn-outline-info">
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.alquileres.edit', $alquiler) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('admin.alquileres.destroy', $alquiler) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this rental?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $alquileres->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-home fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No rentals found</h5>
                            <p class="text-muted">Start by adding your first rental property.</p>
                            <a href="{{ route('admin.alquileres.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add First Rental
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
