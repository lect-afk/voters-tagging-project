@extends('layouts.backend')

@section('content')
<div class="card dashboard_card">
    <div class="card-header">
        <h5>Create Group</h5>
    </div>
    <div class="card-body dashboard_card_body">
        <form action="{{ route('group.store') }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="button-index">
                <i class="fa-solid fa-pen-to-square fa-md"></i>
                <span class="fw-semibold ms-2">Submit</span>
            </button>
            <a href="{{ route('group.index') }}" class="button-index">
                <i class="fa-solid fa-ban fa-md"></i>
                <span class="fw-semibold ms-2">Cancel</span>
            </a>
        </form>
    </div>
</div>
@endsection
