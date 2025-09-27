@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4>Edit Contact Message #{{ $contacto->id }}</h4>
          <a href="{{ route('admin.contacto.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('admin.contacto.update', $contacto) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" value="{{ old('name', $contacto->name) }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email', $contacto->email) }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="text" name="phone" class="form-control" value="{{ old('phone', $contacto->phone) }}">
            </div>

            <div class="mb-3">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control" value="{{ old('subject', $contacto->subject) }}" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" rows="6" class="form-control" required>{{ old('message', $contacto->message) }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Service</label>
                <select name="service" class="form-select" required>
                  <option value="general" {{ old('service', $contacto->service) === 'general' ? 'selected' : '' }}>General</option>
                  <option value="airpods" {{ old('service', $contacto->service) === 'airpods' ? 'selected' : '' }}>AirPods</option>
                  <option value="alquileres" {{ old('service', $contacto->service) === 'alquileres' ? 'selected' : '' }}>Alquileres</option>
                  <option value="taller" {{ old('service', $contacto->service) === 'taller' ? 'selected' : '' }}>Taller</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                  <option value="new" {{ old('status', $contacto->status) === 'new' ? 'selected' : '' }}>New</option>
                  <option value="read" {{ old('status', $contacto->status) === 'read' ? 'selected' : '' }}>Read</option>
                  <option value="replied" {{ old('status', $contacto->status) === 'replied' ? 'selected' : '' }}>Replied</option>
                  <option value="closed" {{ old('status', $contacto->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Admin Notes</label>
              <textarea name="admin_notes" rows="4" class="form-control">{{ old('admin_notes', $contacto->admin_notes) }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
