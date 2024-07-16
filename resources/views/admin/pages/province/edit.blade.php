@extends('layouts.backend')

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2>Edit Province</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('province.update', $province->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $province->name }}" required>
                    </div>
                    <button type="submit" class="button-index">
                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                        <span class="fw-semibold ms-2">Update</span>
                    </button>
                    <a href="{{ route('province.index') }}" class="button-index">
                        <i class="fa-solid fa-ban fa-xl"></i>
                        <span class="fw-semibold ms-2">Cancel</span>
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
