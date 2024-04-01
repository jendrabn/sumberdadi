@extends('layouts.admin')

@section('title', $event->name)

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Edit Event</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Edit Event: {{ $event->name }}</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <form action="{{ route('admin.events.update', $event->id) }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="name">Name</label>
              <input class="form-control"
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $event->name) }}"
                autocomplete="name"
                placeholder="Event name"
                required>
              <span class="form-text text-muted">
                Event name
              </span>
            </div>

            <div class="form-group">
              <label for="community_id">Community</label>
              <select class="form-control"
                id="community_id"
                name="community_id"
                required
                disabled>
                <option value="{{ $event->community->id }}"
                  selected>{{ $event->community->name }}</option>
              </select>
            </div>

            <div class="form-group">
              <label for="location">Location</label>
              <input class="form-control"
                id="location"
                name="location"
                type="text"
                value="{{ old('location', $event->location) }}"
                placeholder="Location">
            </div>

            <div class="form-group">
              <label for="image">Banner</label>
              <div class="custom-file">
                <input class="custom-file-input"
                  id="image"
                  name="image"
                  type="file"
                  value="{{ $event->banner }}">
                <label class="custom-file-label"
                  for="image">Choose file</label>
              </div>
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control summernote"
                id="description"
                name="description">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="form-group">
              <label for="max_attendees">Max Attendee</label>
              <input class="form-control"
                id="max_attendees"
                name="max_attendees"
                type="number"
                value="{{ old('max_attendees', $event->max_attendees) }}">
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="started_at">Started At</label>
                <input class="form-control"
                  id="started_at"
                  name="started_at"
                  type="datetime-local"
                  value="{{ old('started_at', $event->started_at->format('Y-m-d\TH:i')) }}"
                  required>
              </div>
              <div class="form-group col-md-6">
                <label for="ended_at">Ended At</label>
                <input class="form-control"
                  id="ended_at"
                  name="ended_at"
                  type="datetime-local"
                  value="{{ old('ended_at', $event->ended_at->format('Y-m-d\TH:i')) }}">
              </div>
            </div>

            <button class="btn btn-flat btn-primary"
              type="submit"><i class="fa fa-save mr-1"></i> Save
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
