@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4>Contact Message #{{ $contacto->id }}</h4>
          <div class="btn-group">
            <a href="{{ route('admin.contacto.index') }}" class="btn btn-sm btn-outline-secondary">Back</a>
            <a href="{{ route('admin.contacto.edit', $contacto) }}" class="btn btn-sm btn-primary">Edit</a>
          </div>
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{ $contacto->name }}</dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"><a href="mailto:{{ $contacto->email }}">{{ $contacto->email }}</a></dd>

            <dt class="col-sm-3">Phone</dt>
            <dd class="col-sm-9">{{ $contacto->phone ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Subject</dt>
            <dd class="col-sm-9">{{ $contacto->subject }}</dd>

            <dt class="col-sm-3">Service</dt>
            <dd class="col-sm-9"><span class="badge bg-info">{{ $contacto->service_label }}</span></dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9"><span class="badge {{ $contacto->status_badge }}">{{ ucfirst($contacto->status) }}</span></dd>

            <dt class="col-sm-3">Message</dt>
            <dd class="col-sm-9"><pre class="mb-0" style="white-space: pre-wrap;">{{ $contacto->message }}</pre></dd>

            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ $contacto->created_at->format('M d, Y H:i') }}</dd>
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
