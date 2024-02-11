@extends('layouts.app')

@section('title', 'Create Community Event')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Community Event</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Create a new community events</h4>
                        </div>
                        <div class="card-body">
                            @include('partials.alerts')
                            <form action="{{ route('admin.events.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" autocomplete="name" name="name" id="name" placeholder="Event name" class="form-control" value="{{ old('name') }}" required>
                                    <span class="form-text text-muted">
                                        Event name
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label for="community_id">Community</label>
                                    <select name="community_id" id="community_id" class="form-control select2" required>
                                        @foreach($communities as $id => $community)
                                            <option value="{{$id}}">{{$community}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" placeholder="Location" id="location" name="location" value="{{old('location')}}">
                                </div>

                                <div class="form-group">
                                    <label for="image">Banner</label>
                                    <input type="file" name="image" id="image" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control summernote">{{old('description')}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="max_attendees">Max Attendee</label>
                                    <input type="number" name="max_attendees" id="max_attendees" value="{{old('max_attendees', 10000)}}" class="form-control">
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="started_at">Started At</label>
                                        <input type="datetime-local" name="started_at" id="started_at" value="{{old('started_at')}}" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="ended_at">Ended At</label>
                                        <input type="datetime-local" name="ended_at" id="ended_at" value="{{old('ended_at')}}" class="form-control">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-md btn-primary" value="Save">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
