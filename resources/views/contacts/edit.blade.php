@extends('layouts.app')

@section('content')
<h2>Edit Contact</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('contacts.update', $contact->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ $contact->first_name }}" required>
    </div>

    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ $contact->last_name }}" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $contact->email }}" required>
    </div>

    <div class="mb-3">
        <label for="phone_number" class="form-label">Phone Number</label>
        <input type="text" name="phone_number" class="form-control" value="{{ $contact->phone_number }}" required>
    </div>

    <div class="mb-3">
        <label for="company_name" class="form-label">Company Name</label>
        <input type="text" name="company_name" class="form-control" value="{{ $contact->company_name }}">
    </div>

    <button type="submit" class="btn btn-primary">Update Contact</button>
    <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
