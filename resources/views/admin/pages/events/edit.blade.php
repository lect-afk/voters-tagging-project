@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Event</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('events.update', $event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name">Event Name:</label>
                        <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="date">Event Date:</label>
                        <input type="date" name="date" class="form-control" value="{{ $event->date }}" required>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-md"></i>
                        <span class="fw-semibold ms-2">Submit</span>
                    </button>
                    <a href="{{ route('events.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-md"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
